# Tasks

---

- [Index](#index)
- [Create](#create)
- [View](#view)
- [Update](#update)

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

This endpoint indexes all tasks in TMS.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/tasks`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
page  <small>(url param)</small> | integer | No | Which page of the paginated response we should return.
search <small>(url param)</small> | string | No | Search with task title or category.
client_id <small>(url param)</small> | integer | No | Filter on a specific client_id.
user_id <small>(url param)</small> | integer | No | Filter on a specific user_id.
template_id <small>(url param)</small> | integer | No | Filter on a specific template_id.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/tasks&page=1 \
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
        "newsletter": true,
        "custom_fields": {
          "label": null,
          "owner_id": null,
          "cheker_id": null,
          "numbers": null
        }
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
    },
    ...
  ],
  "links": {
    "first": "https://{environment}.synega.com/api/v3/tasks?page=1",
    "last": "https://{environment}.synega.com/api/v3/tasks?page=5655",
    "prev": null,
    "next": "https://{environment}.synega.com/api/v3/tasks?page=2"
  },
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5655,
    "links": [
      {
        "url": null,
        "label": "&laquo; Previous",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/tasks?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "https://{environment}.synega.com/api/v3/tasks?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": null,
        "label": "...",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/tasks?page=5655",
        "label": "5655",
        "active": false
      },
      {
        "url": "https://{environment}.synega.com/api/v3/tasks?page=2",
        "label": "Next &raquo;",
        "active": false
      }
    ],
    "path": "https://{environment}.synega.com/api/v3/tasks",
    "per_page": 10,
    "to": 10,
    "total": 56542
  }
}
```

<a name="create"></a>
## Create

This endpoint creates a task in TMS.

### HTTP Request

`POST https://{environment}.synega.com/api/v3/tasks`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
template_id | integer | No | The ID of the template to create a task on.
client_id | integer | **Yes** | The ID of the client to create a task for.
parent_id | integer | No | The ID task the current task is being regenerated from.
user_id | integer | No | The ID of the assignee of the task.
author_id | integer | No | The ID of the author of the task.
version_no | integer | No | The version number of the task template.
category | string | No | The category of the task.
title | string | **Yes** (if no template_id) | The title of the task.
repeating | boolean | No | Determines if a task is repeating or not.
frequency | string | **Yes** (if repeating true) | The frequency of repeats of the task.
deadline | date | **Yes** | The deadline of the task.
due_at | date | No | The due date of the task.
due_at_update_count | integer | No | The number of updates of due_at date of the task.
end_date | date | No | The end date of the task.
extra_time | integer | No | The extra time given to the task to be completed.
estimation | float | No | The estimation of the time needed to complete the task.
active | boolean | No | Determines if a task is active or not.
regenerated | boolean | No | Determines if a task was regenerated or not.
private | boolean | No | Determines if a task is private or not.
delivered | boolean | No | Determines if a task is delivered or not.
delivered_read_at | date | No | The date when the task 'delivered' state was seen.
completed_at | date | No | The datetime of the task completion.
billable | boolean | **Yes** (if no template_id) | Determines if a task is billable or not.
protected | boolean | **Yes** (if no template_id) | Determines if a task is protected or not.


### Example Request

```shell
curl -X POST https://{environment}.synega.com/api/v3/tasks \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "title": "New Task Title",
       "client": 3,
       "deadline": "2022-04-10 23:59:00",
       "billable": true,
       "protected": false,
       "active": false
    }'
```

### Example Response

```json
{
    "data": {
      "id": 200,
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
        "newsletter": true,
        "custom_fields": {
          "label": null,
          "owner_id": null,
          "cheker_id": null,
          "numbers": null
        }
      },
      "parent": null,
      "user": null,
      "author": null,
      "details": {
        "billable": true,
        "protected": false,
        "description": ""
      },
      "version_no": 1,
      "category": "Avstemming",
      "title": "New Task Title",
      "repeating": true,
      "frequency": "2 months 10",
      "deadline": "2022-04-10 23:59:00",
      "due_at": "2022-10-15 00:00:00",
      "due_at_update_count": 0,
      "end_date": null,
      "extra_time": 0,
      "estimation": null,
      "active": false,
      "regenerated": true,
      "private": false,
      "delivered": false,
      "delivered_read_at": null,
      "completed_at": null
    }
}
```

<a name="view"></a>
## View

This endpoint shows a specific task.

### HTTP Request

`GET https://{environment}.synega.com/api/v3/tasks/{task_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
task_id  <small>(url param)</small> | integer | **Yes** | The unique ID of the task.

### Example Request

```shell
curl -X GET https://{environment}.synega.com/api/v3/tasks/{task_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
```

### Example Response

```json
{
    "data": {
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
        "newsletter": true,
        "custom_fields": {
          "label": null,
          "owner_id": null,
          "cheker_id": null,
          "numbers": null
        }
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
        "work_title": "Manager",
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
}
```

<a name="update"></a>
## Update

This endpoint updates a task.

### HTTP Request

`PATCH https://{environment}.synega.com/api/v3/tasks/{task_id}`

### Request Parameters

Parameter | Type | Required | Description
--------- | ---- | -------- | -----------
template_id | integer | No | The ID of the template to create a task on.
client_id | integer | No | The ID of the client to create a task for.
parent_id | integer | No | The ID task the current task is being regenerated from.
user_id | integer | No | The ID of the assignee of the task.
author_id | integer | No | The ID of the author of the task.
version_no | integer | No | The version number of the task template.
category | string | No | The category of the task.
title | string | No | The title of the task.
repeating | boolean | No | Determines if a task is repeating or not.
frequency | string | **Yes** (if repeating true) | The frequency of repeats of the task.
deadline | date | No | The deadline of the task.
due_at | date | No | The due date of the task.
due_at_update_count | integer | No | The number of updates of due_at date of the task.
end_date | date | No | The end date of the task.
estimation | float | No | The estimation of the time needed to complete the task.
active | boolean | No | Determines if a task is active or not.
regenerated | boolean | No | Determines if a task was regenerated or not.
private | boolean | No | Determines if a task is private or not.
delivered | boolean | No | Determines if a task is delivered or not.
delivered_read_at | date | No | The date when the task 'delivered' state was seen.
completed_at | date | No | The datetime of the task completion.

### Example Request

```shell
curl -X PATCH https://{environment}.synega.com/api/v3/tasks/{task_id} \
    -H "Authorization: Bearer { access_token }
        Content-Type: application/json
        Accept: application/json"
    -d '{
       "extra_time": 60,
       "title": "New Title",
       "author_id": 1,
    }'
```

### Example Response

```json
{
    "data": {
      "id": 200,
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
        "newsletter": true,
        "custom_fields": {
          "label": null,
          "owner_id": null,
          "cheker_id": null,
          "numbers": null
        }
      },
      "parent": null,
      "user": null,
      "author": {
        "id": 1,
        "synega_id": null,
        "manager_id": 1,
        "external_id": null,
        "role": 10,
        "active": true,
        "level": 6,
        "name": "James Mann",
        "work_title": "Autorisert regnskapsfører",
        "email": "jamesmann@example.com",
        "phone": 4700000000,
        "out_of_office": false,
        "about": "",
        "profile_picture_url": "https://local-example-tms-storage.s3.eu-west-1.amazonaws.com/images/profile/default.png"
      },
      "details": {
        "billable": true,
        "protected": false,
        "description": ""
      },
      "version_no": 1,
      "category": "Avstemming",
      "title": "New Title",
      "repeating": true,
      "frequency": "2 months 10",
      "deadline": "2022-04-10 23:59:00",
      "due_at": "2022-10-20 00:00:00",
      "due_at_update_count": 0,
      "end_date": null,
      "extra_time": 60,
      "estimation": null,
      "active": false,
      "regenerated": true,
      "private": false,
      "delivered": false,
      "delivered_read_at": null,
      "completed_at": null
    }
}
```
