# Meetings

---

- [Index](#index)
- [Create](#create)

### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the meeting object.
uuid | string | The unique UUID of the meeting.
name | string | The name of the meeting and room identifier in Twilio. 
completed | boolean | Determines if the meeting is completed or not.
participant_count | integer | The number of participants at the moment.
starts_at | datetime | The date when meeting room is opening.
ends_at | datetime | The date of expiration.

<a name="index"></a>
## Index

This endpoint indexes all meetings in Meet.

### HTTP Request

`GET https://{environment}.synega.com/api/v1/meetings`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page | integer | No | Which page of the paginated response we should return.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v1/meetings?page=1 \
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
      "uuid": "573bf2e9-6c0d-47e6-a10b-667a1b899f7e",
      "name": "Meeting 001",
      "completed": 1,
      "participant_count": 0,
      "starts_at": "2021-12-01 12:00:00",
      "ends_at": "2021-11-02 12:00:00",
      "created_at": "2021-11-07 14:12:26",
      "link": "https://{environment}.synega.com/meetings/573bf2e9-6c0d-47e6-a10b-667a1b899f7e"
    },
    {
      "id": 2,
      "uuid": "3798486f-630c-4b0e-bd66-5330becd62cc",
      "name": "Meeting 002",
      "completed": 0,
      "participant_count": 0,
      "starts_at": "2021-12-01 12:00:00",
      "ends_at": "2021-12-02 12:00:00",
      "created_at": "2021-11-07 14:17:28",
      "link": "https://{environment}.synega.com/meetings/3798486f-630c-4b0e-bd66-5330becd62cc"
    },
    {
      "id": 3,
      "uuid": "78ab35c6-e06b-451b-8bd5-4e483e3ae559",
      "name": "Meeting 003",
      "completed": 0,
      "participant_count": 0,
      "starts_at": "2021-12-01 12:00:00",
      "ends_at": "2021-11-10 11:52:28",
      "created_at": "2021-11-08 12:22:21",
      "link": "https://{environment}.synega.com/meetings/78ab35c6-e06b-451b-8bd5-4e483e3ae559"
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v1/meetings?page=1",
    "last": "https://{environment}.synega.com/api/v1/meetings?page=2",
    "prev": null,
    "next": "https://{environment}.synega.com/api/v1/meetings?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 2,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/meetings?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "https://{environment}.synega.com/api/v1/meetings?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v1/meetings?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v1/meetings",
    "per_page": 10,
    "to": 10,
    "total": 15
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a meeting in Meet.

### HTTP Request

`POST https://{environment}.synega.com/api/v1/meetings`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
name | string | **Yes** | The name of the meeting and room identifier in Twilio.
starts_at | datetime | No | The date when meeting room is opening. Will be set `current time` if no date provided.

### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v1/meetings \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
        "name": "Meeting 004",
    }'
```

### Example Response

```json
{
  "data": {
    "id": 4,
    "uuid": "583bf2e9-6c0d-47e6-a10b-667a1b899f7e",
    "name": "Meeting 004",
    "completed": 0,
    "participant_count": 0,
    "starts_at": "2021-12-01 12:00:00",
    "ends_at": "2021-11-02 12:00:00",
    "created_at": "2021-11-07 14:12:26",
    "link": "https://{environment}.synega.com/meetings/583bf2e9-6c0d-47e6-a10b-667a1b899f7e"
  }
}
```
