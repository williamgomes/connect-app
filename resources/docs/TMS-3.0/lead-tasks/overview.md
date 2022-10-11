# Lead tasks

---

- [Index](#index)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the lead task object
type | string | The type of the lead task 
title | string | The title of the lead task 
description | string | The description of the lead task 
deadline | integer | The deadline in hours which is supposed to be set on a task 
private | boolean | Determines if the created task will be private or not 
active | boolean | Determines if lead task is active or not 

<a name="index"></a>
## Index

This endpoint indexes all lead tasks in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/lead-tasks`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page <small>(url param)</small> | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/lead-tasks?page=1 \
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
      "type": "client_lead",
      "title": "Bli oppringt",
      "description": "<p>Benyttes om en potensiell kunde skal ringes opp.</p>",
      "deadline": 1,
      "private": false,
      "active": true
    },
    {
      "id": 2,
      "type": "user_lead",
      "title": "Konsulent lead",
      "description": "<p>Benyttes ved oppf&oslash;lging av konsulent leads</p>",
      "deadline": 1,
      "private": false,
      "active": true
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/lead-tasks?page=1",
    "last": "https://{environment}.synega.com/api/v3/lead-tasks?page=2",
    "prev": null,
    "next": "https://{environment}.synega.com/api/v3/lead-tasks?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "links": [
      {
        "url": null,
        "label": "&laquo; Forrige",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/lead-tasks?page=1",
        "label": 1,
        "active": true
      },
      {
        "url": "https://{environment}.synega.com/api/v3/lead-tasks?page=2",
        "label": 2,
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/lead-tasks?page=2",
        "label": "Neste &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v3/lead-tasks",
    "per_page": 10,
    "to": 10,
    "total": 17
  }
}
```


