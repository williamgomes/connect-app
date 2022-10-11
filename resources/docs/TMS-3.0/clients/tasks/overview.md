# Tasks

---

- [Index](#index)


### Model

Parameter | Type | Description
--------- | ---- | -----------
id | integer | The unique ID for the task object.
template | object | The object of the template the task is created on.
client | object | The object of the client.
parent | object | The object of the parent task the current task was regenerated from.
user | object | The object of the assignee of the task.
author | object | The object of the author of the task.
details | object | The object of the additional details of the task.
version_no | integer | The version number of the task template.
category | string | The category of the task.
title | string | The title of the task.
repeating | boolean | Determines if a task is repeating or not.
frequency | string | The frequency of repeats of the task.
deadline | date | The deadline of the task.
due_at | date | The due date of the task.
due_at_update_count | integer | The number of updates of due_at date of the task.
end_date | date | The end date of the task.
extra_time | integer | The extra time given to the task to be completed.
estimation | float | The estimation of the time needed to complete the task.
active | boolean | Determines if a task is active or not.
regenerated | boolean | Determines if a task was regenerated or not.
private | boolean | Determines if a task is private or not.
delivered | boolean | Determines if a task is delivered or not.
delivered_read_at | date | The date when the task 'delivered' state was seen.
completed_at | date | The datetime of the task completion.

<a name="index"></a>
## Index

This endpoint indexes all tasks of the client without pagination.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/clients/{client_id}/tasks`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
client_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the client which the tasks are linked to.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/clients/{client_id}/tasks \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
  "data": [
    {
      "id": 17,
      "template": null,
      "client": {
        "id": 3,
        "name": "CLIENT EXAMPLE NAME",
        "type": "client",
        "organization_number": 914800000,
        "system": {
          "id": 1,
          "name": "Fiken",
          "visible": true,
          "default": true
        },
        "customer_type": {
          "id": 2,
          "name": "Enkeltpersonforetak (EPF)"
        },
        "manager": {
          "id": 8,
          "synega_id": null,
          "manager_id": 1,
          "external_id": null,
          "role": 10,
          "active": true,
          "level": 6,
          "name": "Jane Ostin",
          "work_title": "Autorisert regnskapsfører",
          "email": "jane_ostin@example.com",
          "phone": 4700000000,
          "out_of_office": false,
          "about": "",
          "profile_picture_url": "https://local-example-tms-storage.s3.eu-west-1.amazonaws.com/images/profile/default.png"
        },
        "employee": {
          "id": 155,
          "synega_id": null,
          "manager_id": 8,
          "external_id": null,
          "role": 30,
          "active": true,
          "level": 0,
          "name": "Julius Mainl",
          "work_title": "Regnskapskonsulent",
          "email": "julius@example.com",
          "phone": 4700000000,
          "out_of_office": false,
          "about": "",
          "profile_picture_url": "https://local-example-tms-storage.s3.eu-west-1.amazonaws.com/images/profile/default.png"
        },
        "invoice_contact_email": null,
        "contact_email": null,
        "contact_phone": null,
        "paid": true,
        "active": true,
        "paused": false,
        "newsletter": true
      },
      "parent": null,
      "user": {
        "id": 59,
        "synega_id": null,
        "manager_id": 119,
        "external_id": null,
        "role": 30,
        "active": true,
        "level": 0,
        "name": "Client",
        "work_title": "Some work title",
        "email": "test@example.com",
        "phone": null,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "https://local-example-tms-storage.s3.eu-west-1.amazonaws.com/images/profile/default.png"
      },
      "author": {
        "id": 59,
        "synega_id": null,
        "manager_id": 119,
        "external_id": null,
        "role": 30,
        "active": true,
        "level": 0,
        "name": "Client",
        "work_title": "Some work title",
        "email": "name@example.no",
        "phone": null,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "https://local-example-tms-storage.s3.eu-west-1.amazonaws.com/images/profile/default.png"
      },
      "version_no": 1,
      "category": "Avstemming",
      "title": "Avstemming (termin MVA)",
      "repeating": true,
      "frequency": "2 months 10",
      "deadline": "2017-04-10 23:59:00",
      "due_at": "2017-10-15 00:00:00",
      "due_at_update_count": 0,
      "end_date": null,
      "extra_time": 0,
      "estimation": null,
      "active": true,
      "regenerated": true,
      "private": false,
      "delivered": false,
      "delivered_read_at": null,
      "completed_at": "2017-10-09 22:18:33"
    }
  ]
}
```
