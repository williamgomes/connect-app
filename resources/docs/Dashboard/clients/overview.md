# Clients

---

- [Index](#index)
- [Create](#create)
- [Show](#show)
- [Update](#update)
- [Delete](#delete)

### Model

Parameter | Type | Description
--------- | ---- | -----------
uuid | string | The UUID of the client 
name | string | The name of the client 
type | string | The type of the client. Can be `individual` or `business` 
id_number | string | The unique per country identification number of the client 
vat_identifier | string | The VAT identifier of the client 
country_id | integer | The ID of the country of the client  
created_at | datetime | The date of the client creation 
updated_at | datetime | The date of the client last update

<a name="index"></a>
## Index

This endpoint indexes all clients in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/clients`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
name | string | No | Search for a specific name. We only return exact match.
uuid | string | No | Search for a specific uuid. We only return exact match.
id_number | string | No | Search for a specific id_number. We only return exact match.
vat_identifier | string | No | Search for a specific vat_identifier. We only return exact match.
country_id | integer | No | Search for a specific country_id.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/clients?page=1 \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "id_number": "ID392922939"
    }'
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "uuid": "1b4fb590-98ae-4a7e-a860-34d08e84b154",
      "name": "GARO AS",
      "type": "business",
      "country": {
        "id": 1,
        "name": "Albania",
        "iso_code": "AL",
        "phone_code": "355"
      },
      "id_number": "ID392922939",
      "vat_identifier": "1341242"
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v1/clients?page=1",
    "last": "https://{environment}.synega.com/api/v1/clients?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/clients?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": null,
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v1/clients",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a client in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/clients`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The name of the client 
type | string | **Yes** | The type of the client. Can be `individual` or `business`
id_number | string | **Yes** | The unique per country identification number of the client
vat_identifier | string | **Yes** | The VAT identifier of the client
country_id | integer | **Yes** | The ID of the country of the client  

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/clients \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "Client 001",
        "type": "individual",
        "id_number": "TT000002",
        "vat_identifier": "20041022aa",
        "country_id": 12
    }'
```

### Example Response

```json
{
  "data": {
    "id": 4,
    "uuid": "aa8aabbb-77dd-47df-916f-f8bf9a566a96",
    "name": "Client 001",
    "type": "individual",
    "country": {
      "id": 13,
      "name": "Bahrain",
      "iso_code": "BH",
      "phone_code": "973"
    },
    "id_number": "TT000002",
    "vat_identifier": "20041022aa"
  }
}
```

<a name="show"></a>
## Show

This endpoint shows a specific client in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/clients/{client_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/clients/{client_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": {
    "id": 4,
    "uuid": "aa8aabbb-77dd-47df-916f-f8bf9a566a96",
    "name": "Client 001",
    "type": "individual",
    "country": {
      "id": 13,
      "name": "Bahrain",
      "iso_code": "BH",
      "phone_code": "973"
    },
    "id_number": "TT000002",
    "vat_identifier": "20041022aa"
  }
}
```

<a name="update"></a>
## Update

This endpoint updates a specific client in TMS.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v1/clients/{client_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | No | The name of the client
type | string | No | The type of the client. Can be `individual` or `business`
id_number | string | No | The unique per country identification number of the client
vat_identifier | string | No | The VAT identifier of the client
country_id | integer | No | The ID of the country of the client

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v1/clients/{client_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "Client 002"
    }'
```

### Example Response

```json
{
  "data": {
    "id": 4,
    "uuid": "aa8aabbb-77dd-47df-916f-f8bf9a566a96",
    "name": "Client 002",
    "type": "individual",
    "country": {
      "id": 13,
      "name": "Bahrain",
      "iso_code": "BH",
      "phone_code": "973"
    },
    "id_number": "TT000002",
    "vat_identifier": "20041022aa"
  }
}
```

<a name="delete"></a>
## Delete

This endpoint deletes a specific client.

### HTTP Request

`DELETE https://{environment}.synega.com/api/v1/clients/{client_id\`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.

### Example Request

```shell
curl -X DELETE https://{environment}.synega.com/api/v1/clients/{client_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```http
HTTP/1.1 204 No Content
```