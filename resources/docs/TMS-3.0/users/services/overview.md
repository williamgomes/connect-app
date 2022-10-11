# User Services

---

- [Index](#index)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the service object.
title | string | The title of the service.

<a name="index"></a>
## Index

This endpoint indexes specific user services in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/users/{user_id}/services`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
user_id <small>(url param)</small> | integer | **Yes** | The unique ID of the user.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/users/{user_id}/services \
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
      "title": "test"
    }
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/users/193/services?page=1",
    "last": "https://{environment}.synega.com/api/v3/users/193/services?page=1",
    "prev": null,
    "next": null
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 1,
    "path": "https://{environment}.synega.com/api/v3/users/193/services",
    "per_page": 10,
    "to": 1,
    "total": 1
  }
}
```
