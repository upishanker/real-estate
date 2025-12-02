-- Database Systems Website Project
-- Query script file

USE real_estate_mls;

-- Query 1: Find the addresses of all houses currently listed
SELECT '=== Query 1: Find the addresses of all houses currently listed ===' as '';
SELECT DISTINCT H.address
FROM House H
         JOIN Listings L ON H.address = L.address;

-- Query 2: Find the addresses and MLS numbers of all houses currently listed
SELECT '=== Query 2: Find the addresses and MLS numbers of all houses currently listed ===' as '';
SELECT L.mlsNumber, H.address
FROM House H
         JOIN Listings L ON H.address = L.address;

-- Query 3: Find the addresses of all 3-bedroom, 2-bathroom houses currently listed
SELECT '=== Query 3: Find the addresses of all 3-bedroom, 2-bathroom houses currently listed ===' as '';
SELECT H.address
FROM House H
         JOIN Listings L ON H.address = L.address
WHERE H.bedrooms = 3 AND H.bathrooms = 2;

-- Query 4: Find the addresses and prices of all 3-bedroom, 2-bathroom houses with prices in the range $100,000 to $250,000, in descending order of price
SELECT '=== Query 4: Find addresses and prices of 3BR/2BA houses ($100K-$250K) in descending price ===' as '';
SELECT H.address, P.price
FROM House H
         JOIN Property P ON H.address = P.address
         JOIN Listings L ON H.address = L.address
WHERE H.bedrooms = 3
  AND H.bathrooms = 2
  AND P.price BETWEEN 100000 AND 250000
ORDER BY P.price DESC;

-- Query 5: Find the addresses and prices of all business properties that are advertised as office space in descending order of price
SELECT '=== Query 5: Find addresses and prices of office space business properties in descending price ===' as '';
SELECT BP.address, P.price
FROM BusinessProperty BP
         JOIN Property P ON BP.address = P.address
         JOIN Listings L ON BP.address = L.address
WHERE BP.type = 'office space'
ORDER BY P.price DESC;

-- Query 6: Find all the ids, names and phones of all agents, together with the names of their firms and the dates when they started
SELECT '=== Query 6: Find agent info with firm names and start dates ===' as '';
SELECT A.agentId, A.name, A.phone, F.name AS firmName, A.dateStarted
FROM Agent A
         JOIN Firm F ON A.firmId = F.id;

-- Query 7: Find all the properties currently listed by agent with id "1"
SELECT '=== Query 7: Find all properties currently listed by agent with id 1 ===' as '';
SELECT P.*
FROM Property P
         JOIN Listings L ON P.address = L.address
WHERE L.agentId = 1;

-- Query 8: Find all Agent.name-Buyer.name pairs where the buyer works with the agent, sorted alphabetically by Agent.name
SELECT '=== Query 8: Find Agent-Buyer pairs sorted by Agent name ===' as '';
SELECT A.name AS AgentName, B.name AS BuyerName
FROM Agent A
         JOIN Works_With W ON A.agentId = W.agentId
         JOIN Buyer B ON W.buyerId = B.id
ORDER BY A.name;

-- Query 9: For each agent, find the total number of buyers currently working with that agent
SELECT '=== Query 9: Find total number of buyers per agent ===' as '';
SELECT A.agentId, A.name, COUNT(W.buyerId) AS buyerCount
FROM Agent A
         LEFT JOIN Works_With W ON A.agentId = W.agentId
GROUP BY A.agentId, A.name;

-- Query 10: For buyer with id 1 (interested in a house), find all houses that meet the buyer's preferences, in descending order of price
SELECT '=== Query 10: Find houses matching buyer 1 preferences in descending price ===' as '';
SELECT H.address, P.price, H.bedrooms, H.bathrooms, H.size
FROM House H
         JOIN Property P ON H.address = P.address
         JOIN Listings L ON H.address = L.address
         JOIN Buyer B ON B.id = 1
WHERE H.bedrooms = B.bedrooms
  AND H.bathrooms = B.bathrooms
  AND P.price BETWEEN B.minimumPreferredPrice AND B.maximumPreferredPrice
ORDER BY P.price DESC;