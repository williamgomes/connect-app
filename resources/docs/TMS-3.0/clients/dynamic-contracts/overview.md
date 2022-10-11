# Dynamic Contracts

---

- [Index](#index)
- [Apply](#apply)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the dynamic contract object under settings.
title | string | The title of the dynamic contract.
active | boolean | Determines if the dynamic contract is active or not.

<a name="index"></a>
## Index

This endpoint indexes all dynamic contracts in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/dynamic-contracts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/dynamic-contracts/{client_id}/dynamic-contracts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 1,
      "title": "Avvikling av selskap",
      "active": true
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/clients/3678/dynamic-contracts?page=1",
    "last": "https://{environment}.synega.com/api/v3/clients/3678/dynamic-contracts?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/clients/3678/dynamic-contracts",
    "per_page": 10,
    "to": 10,
    "total": 10
  }
}
```

<a name="apply"></a>
## Apply

This endpoint applies a dynamic contract on the client.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/dynamic-contracts/{client_id}/dynamic-contracts`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id <small>(url param)</small> | integer | **Yes** | The unique ID of the client.
contract_id | integer | **Yes** | The unique ID of the dynamic contract.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/dynamic-contracts/{client_id}/dynamic-contracts \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "contract_id": 2
    }'
```

### Example Response

```http
HTTP/1.1 204 No Content
```


