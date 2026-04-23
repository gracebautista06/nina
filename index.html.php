<!DOCTYPE html>
<html>
<head>
    <title>ICAS Property Dashboard</title>
    <style>
        body {
            font-family: Arial;
            margin: 20px;
            background: #f4f6f9;
        }
        h1 {
            color: #333;
        }
        .card {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        input, button {
            padding: 8px;
            margin: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #007bff;
            color: white;
        }
        button {
            cursor: pointer;
        }
        .btn-delete {
            background: red;
            color: white;
        }
    </style>
</head>
<body>

<h1>📊 ICAS Property Dashboard</h1>

<div class="card">
    <h3>Add Property</h3>
    <input id="code" placeholder="Code">
    <input id="name" placeholder="Name">
    <input id="location" placeholder="Location">
    <input id="value" placeholder="Value" type="number">
    <button onclick="addProperty()">Add</button>
</div>

<div class="card">
    <h3>Property List</h3>
    <table id="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Code</th>
                <th>Name</th>
                <th>Location</th>
                <th>Value</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<script>
const API = "http://127.0.0.1:5000/properties";

async function loadProperties() {
    const res = await fetch(API);
    const data = await res.json();

    const tbody = document.querySelector("#table tbody");
    tbody.innerHTML = "";

    data.forEach(p => {
        tbody.innerHTML += `
            <tr>
                <td>${p.id}</td>
                <td>${p.property_code}</td>
                <td>${p.property_name}</td>
                <td>${p.location || ""}</td>
                <td>${p.value || ""}</td>
                <td>
                    <button onclick="deleteProperty(${p.id})" class="btn-delete">Delete</button>
                </td>
            </tr>
        `;
    });
}

async function addProperty() {
    const data = {
        property_code: document.getElementById("code").value,
        property_name: document.getElementById("name").value,
        location: document.getElementById("location").value,
        value: document.getElementById("value").value
    };

    await fetch(API, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(data)
    });

    loadProperties();
}

async function deleteProperty(id) {
    await fetch(API + "/" + id, { method: "DELETE" });
    loadProperties();
}

loadProperties();
</script>

</body>
</html>