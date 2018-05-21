# Escuelas 

### Endpoints

  - [GET /magazines](#get-magazines)
  - [GET /magazines/[id]](#get-magazinesid)
  - [POST /magazines/[id]/articles](#post-magazinesidarticles)

### GET /escuelas
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