db.dob.createIndex(
	{
		"v25._": "text",
		"v30._": "text",
		"v40._": "text",
		"v43._": "text"
	},
	{
		name: "DobIndex"
	},
	{ default_language: "portuguese" }
);
db.ape.createIndex(
	{
		"v30._": "text",
		"v43._": "text"
	},
	{
		name: "ApeIndex"
	},
	{ default_language: "portuguese" }
);