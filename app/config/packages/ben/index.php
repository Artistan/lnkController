<?php

return [
		"indices" => [
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk",
								"type" => "alliances",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"name" => [
														"type" => "string"
												],
												"rankAverage" => [
														"type" => "integer"
												],
												"rank" => [
														"type" => "integer"
												],
												"points" => [
														"type" => "integer"
												],
												"pointsAverage" => [
														"type" => "integer"
												],
												"description" => [
														"type" => "string"
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-8/alliances.json.gz"],
								],
								"transformers" => [],
						],
				],
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk",
								"type" => "players",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"nick" => [
														"type" => "string"
												],
												"points" => [
														"type" => "integer"
												],
												"rank" => [
														"type" => "integer"
												],
												"underAttackProtection" => [
														"type" => "boolean"
												],
												"onVacation" => [
														"type" => "boolean"
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-8/players.json.gz"],
								],
								"transformers" => [],
						],
				],
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk",
								"type" => "habitats",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										"transform" => [
												"lang" => "groovy",
												"script" => "ctx._source['location']=[ctx._source['mapX'],ctx._source['mapY']]"
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"name" => [
														"type" => "string"
												],
												"mapX" => [
														"type" => "integer"
												],
												"mapY" => [
														"type" => "integer"
												],
												"points" => [
														"type" => "integer"
												],
												"creationDate" => [
														"type" => "integer"
												],
												"playerID" => [
														"type" => "integer"
												],
												"publicType" => [
														"type" => "integer"
												],
												"location" => [
														"type" => "geo_point",
														"geohash" => true,
														"lat_lon" => true,
														"geohash_precision" => '1km',
														"geohash_prefix" => true,
														"validate" => false,
														"validate_lon" => false,
														"validate_lat" => false,
														"precision_step" => 1,
														"normalize" => false,
														"normalize_lon" => false,
														"normalize_lat" => false,
														"fielddata" => [
																"format" => "compressed",
																"precision" => "1km"
														]
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-8/habitats.json.gz"],
								],
								"transformers" => [],
						],
				],
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk9",
								"type" => "alliances",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"name" => [
														"type" => "string"
												],
												"rankAverage" => [
														"type" => "integer"
												],
												"rank" => [
														"type" => "integer"
												],
												"points" => [
														"type" => "integer"
												],
												"pointsAverage" => [
														"type" => "integer"
												],
												"description" => [
														"type" => "string"
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-9/alliances.json.gz"],
								],
								"transformers" => [],
						],
				],
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk9",
								"type" => "players",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"nick" => [
														"type" => "string"
												],
												"points" => [
														"type" => "integer"
												],
												"rank" => [
														"type" => "integer"
												],
												"underAttackProtection" => [
														"type" => "boolean"
												],
												"onVacation" => [
														"type" => "boolean"
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-9/players.json.gz"],
								],
								"transformers" => [],
						],
				],
				[
						"frequency" => [],
						"dateFormat" => 'Y-m-d',
						"timezone" => 'CST',
						"versionThreshold" => 500,
						"definition" => [
								"index" => "lnk9",
								"type" => "habitats",
								"number_shards" => "1",
								"number_replica" => "1",
								"mappings" => [
										'_source' => [
												'enabled' => true
										],
										'_timestamp' => [
												'store' => true,
												'index' => 'analyzed',
												'enabled' => true
										],
										"transform" => [
												"lang" => "groovy",
												"script" => "ctx._source['location']=[ctx._source['mapX'],ctx._source['mapY']]"
										],
										'properties' => [
												"id" => [
														"type" => "integer"
												],
												"name" => [
														"type" => "string"
												],
												"mapX" => [
														"type" => "integer"
												],
												"mapY" => [
														"type" => "integer"
												],
												"points" => [
														"type" => "integer"
												],
												"creationDate" => [
														"type" => "integer"
												],
												"playerID" => [
														"type" => "integer"
												],
												"publicType" => [
														"type" => "integer"
												],
												"location" => [
														"type" => "geo_point",
														"geohash" => true,
														"lat_lon" => true,
														"geohash_precision" => '1km',
														"geohash_prefix" => true,
														"validate" => false,
														"validate_lon" => false,
														"validate_lat" => false,
														"precision_step" => 1,
														"normalize" => false,
														"normalize_lon" => false,
														"normalize_lat" => false,
														"fielddata" => [
																"format" => "compressed",
																"precision" => "1km"
														]
												]
										],
								],
								"source" => [
										"type" => "json",
										"location" => ["http://public-data.lordsandknights.com/LKWorldServer-US-9/habitats.json.gz"],
								],
								"transformers" => [],
						],
				],
		],
];
