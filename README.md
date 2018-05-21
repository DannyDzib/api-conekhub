# Escuelas 

### Endpoints

  - GET     /api/escuelas
  - GET     /api/escuela/{id}
  - POST    /api/escuela/{id}/carreras

### GET /api/escuelas
+ Response 200 
```json
    [
        {
            "id_escuela":"",
            "escuela":"",
            "matricula":""
        }
    ]
```

### GET /api/escuela/{id}
+ Response 200 
```json
    [ 
        {
            "id_escuela": 1,
            "escuela":"string",
            "matricula": 1
        }
    ]
```


### GET /api/escuela/{id}/carreras
+ Response 200 
```json
    [
        {
            "carrera":"string"
        },
        {
            "carrera":"string"
        }
    ]
```

### POST /usuarios/registrar
+ Body 
```json
    {
        "nombre": "string",
        "apellidos": "string",
        "correo": "string",
        "pass": "string",
        "id_escuela": 1,
        "id_carrera": 1,
        "id_grado": 6
    }
```