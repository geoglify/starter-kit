const WebSocket = require('ws');
const { createClient } = require('redis');

// Configuration
const AISSTREAM_API_KEY = process.env.AISSTREAM_API_KEY || "7fb1e16f93a4d520d83a95e325c55e69b3b4fc0b";
const AIS_SERVER_HOST = process.env.AIS_SERVER_HOST || "aisstream.io";
const REDIS_HOST = process.env.REDIS_HOST || "127.0.0.1";
const REDIS_PORT = process.env.REDIS_PORT || 6379;

// Connect to Redis using the new Promise-based API
const redisClient = createClient({
  url: `redis://${REDIS_HOST}:${REDIS_PORT}`
});

redisClient.on('error', (err) => {
  console.error('Connection error to Redis:', err);
});

// Function to connect to Redis
async function connectRedis() {
  await redisClient.connect(); // Asynchronous method to connect to Redis
  console.log('Connected to Redis');
}

// Function to decode the AIS message
function decodeStreamMessage(message) {
  let ship = {
    mmsi: message.MetaData.MMSI.toString(),
    name: message.MetaData.ShipName.trim(),
    utc: new Date(message.MetaData.time_utc),
    location: {
      type: "Point",
      coordinates: [message.MetaData.longitude, message.MetaData.latitude],
    },
    ais_server_host: AIS_SERVER_HOST,
    cog: message?.Message?.PositionReport?.Cog || message?.Message?.StandardClassBPositionReport?.Cog,
    sog: message?.Message?.PositionReport?.Sog || message?.Message?.StandardClassBPositionReport?.Sog,
    hdg: message?.Message?.PositionReport?.TrueHeading || message?.Message?.StandardClassBPositionReport?.TrueHeading,
    dimA: message?.Message?.ShipStaticData?.Dimension?.A,
    dimB: message?.Message?.ShipStaticData?.Dimension?.B,
    dimC: message?.Message?.ShipStaticData?.Dimension?.C,
    dimD: message?.Message?.ShipStaticData?.Dimension?.D,
    imo: message?.Message?.ShipStaticData?.ImoNumber,
    destination: message?.Message?.ShipStaticData?.Destination,
    cargo: message?.Message?.ShipStaticData?.Type,
    callsign: message?.Message?.ShipStaticData?.CallSign,
    draught: message?.Message?.ShipStaticData?.MaximumStaticDraught,
  };

  let etaObj = message?.Message?.ShipStaticData?.Eta;
  let eta = etaObj ? new Date(etaObj.Year ?? new Date().getFullYear(), etaObj.Month, etaObj.Day, etaObj.Hour, etaObj.Minute) : null;
  ship.eta = eta;

  return ship;
}

// Function to push AIS messages onto the Redis queue
async function queueAisMessage(shipData) {
  try {
    const shipDataString = JSON.stringify(shipData);
    await redisClient.publish('geoglify_database_ais_message', shipDataString); // Adds the message to the Redis queue
    console.log(`Ship data for ${shipData.mmsi} added to Redis queue.`);
  } catch (error) {
    console.error(`Failed to queue ship data for ${shipData.mmsi}:`, error);
  }
}

// Function to process AIS messages
async function processAisMessage(message) {
  const ship = decodeStreamMessage(message);
  const shipData = {
    mmsi: ship.mmsi,
    name: ship.name || null,
    callsign: ship.callsign || null,
    imo: ship.imo || null,
    dimA: ship.dimA || null,
    dimB: ship.dimB || null,
    dimC: ship.dimC || null,
    dimD: ship.dimD || null,
    cargo: ship.cargo || null,
    draught: ship.draught || null,
    cog: ship.cog || null,
    sog: ship.sog || null,
    hdg: ship.hdg || null,
    utc: ship.utc || null,
    eta: ship.eta || null,
    destination: ship.destination || null,
    geojson: ship.location || null,
  };

  // Send the data to the Redis queue
  await queueAisMessage(shipData);
}

// Main function to initiate processing
async function main() {
  await connectRedis(); // Connect to Redis before starting
  connectToAisStreamWithRetry();
}

// Function to connect to the AIS stream with retry logic
async function connectToAisStreamWithRetry() {
  try {
    console.log("Connecting to AIS stream...");
    const socket = new WebSocket("wss://stream.aisstream.io/v0/stream");

    socket.onopen = function () {
      console.log("Connected to AIS stream");
      let subscriptionMessage = {
        Apikey: AISSTREAM_API_KEY,
        BoundingBoxes: [
          [
            [29.343875, -35.419922],
            [45.690833, 6.394043],
          ],
        ],
      };
      socket.send(JSON.stringify(subscriptionMessage)); // Send the subscription message
    };

    socket.onclose = function () {
      console.error("WebSocket closed, retrying...");
      setTimeout(connectToAisStreamWithRetry, 5000); // Retry connection after 5 seconds
    };

    socket.onmessage = async (event) => {
      let aisMessage = JSON.parse(event.data); // Parse the incoming message
      processAisMessage(aisMessage); // Process the AIS message
    };
  } catch (err) {
    console.error("Failed to connect to AIS stream, retrying...");
    setTimeout(connectToAisStreamWithRetry, 5000); // Retry connection after 5 seconds
  }
}

// Execute the main function
main();
