/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**Ejemplo solicitudes**/
/***Ejemplo de solicitud metodo autorizacion****/
[
    
    {
        "jsonrpc": "2.0",
        "method": "retenerLiberarReceta",
        "params": {
            "llave": "a3acc5cf8325ea88df3cbd720055487d8d7de501",
            "receta": "285296",
            "accion": 'R'
        },
        "id": "a3acc5cf8325ea88df3cbd720055487d8d7de501"
 },
    {
        "jsonrpc": "2.0",
        "method": "autorizacion",
        "params": {
            "llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
            "codDoctor": "11019",
            "tipo": "1",
            "Carnet": "041380887",
            "tipoDoc": "1",
            "doc": "00118763267",
            "medicamentos":[
                {
                    "codMedicamento": "1724000",
                    "cantidad": "1",
                    "dosis": "1",
                    "dias": "1",
                    "precio": "123"
                    
                },
                {
                    "codMedicamento": "1724200",
                    "cantidad": "2",
                    "dosis": "2",
                    "dias": "1",
                    "precio": "200"
                    
                }
                
            ]
        },
        "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7"
    }
]
/***Ejemplo de solicitud metodo que genera la llave****/
[
    {
        "jsonrpc": "2.0",
        "method": "sesion",
        "params": {
            "usuario": "jesus2312",
            "clave": "15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225",
            "codPSS": "218",
            "codARS": "23",
            "docTipo": "1",
            "doc": "00118763267"
        },
        "id": ""
    }
]

/***Ejemplo de solicitud metodo doctor****/
[
    {
        "jsonrpc": "2.0",
        "method": "doctor",
        "params": {
            "llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
            "nomDoctor": "jua"
        },
        "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7"
    }
]


/***Ejemplo de metodo reversion****/

[
    
      {
        "jsonrpc": "2.0",
        "method": "reversion",
        "params": {
            "llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
            "codAutorizacion": "S191690759494",
            "comentario": "Prueba Reversion Transaccional",
            "medicamentos":[
                {
                    "codMedicamento": "1004018"  //medicamento a reversar
                    
                },
                {
                    "codMedicamento": "1724200" //medicamento a reversar
                    
                }
                
            ]
        },
        "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7"
    }
    
]


/**********************************Ejemplo de response estandar*****************/



[
  {
   "result": {
       "status":    {
         "codRespuesta": 404,
         "desRespuesta": "DB ERROR!!"
        }
   },
   "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
   "jsonrpc": "2.0"
  }
]


/**Response sesion**/

[
{
   "result":    {
      "status":       {
         "codRespuesta": 0,
         "desRespuesta": "Ya existe una llave activa."
      },
      "sesion": {"llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7"}
   },
   "id": "",
   "jsonrpc": "2.0"
}
]


/**Response sesion error***/

[
    {
   "result": {"status":    {
      "codRespuesta": 101,
      "desRespuesta": "Credenciales invalidas."
   }},
   "id": "",
   "jsonrpc": "2.0"
}
    
]


/**Response autorizacion**/
[
    {
       "result":    {
          "status":       {
             "Llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
             "codRespuesta": 0,
             "desRespuesta": "Procesado.",
             "codAutorizacion": "S191690759494"
          },
          "autorizacion":       [
                      {
                "wCOD_AUTORIZACION": "S191690759494",
                "wCOD_COBERTURA": "1724200",
                "wCANT_MEDICAMENTOS": "2",
                "wMONTO_PRECIO": "200.00",
                "wMONTO_CUBIERTO": "140.00",
                "wAUTORIZADO": "1",
                "wRESPUESTA_CORTA": "AUTORIZADO",
                "wRESPUESTA_LARGA": "000|AUTORIZADO"
             },
                      {
                "wCOD_AUTORIZACION": "S191690759494",
                "wCOD_COBERTURA": "1004018",
                "wCANT_MEDICAMENTOS": "1",
                "wMONTO_PRECIO": "123.00",
                "wMONTO_CUBIERTO": "86.10",
                "wAUTORIZADO": "1",
                "wRESPUESTA_CORTA": "AUTORIZADO",
                "wRESPUESTA_LARGA": "000|AUTORIZADO"
             }
          ]
       },
       "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
       "jsonrpc": "2.0"
    }
]

/**Response autorizacion error***/

[
    {
   "result":    {
      "status":       {
         "Llave": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
         "codRespuesta": 0,
         "desRespuesta": "Procesado.",
         "codAutorizacion": "S201690842849"
      },
      "autorizacion": [      {
         "wCOD_AUTORIZACION": "S201690842849",
         "wCOD_COBERTURA": "1724200",
         "wCANT_MEDICAMENTOS": "2",
         "wMONTO_PRECIO": "400.00",
         "wMONTO_CUBIERTO": "0.00",
         "wAUTORIZADO": "0",
         "wRESPUESTA_CORTA": "TRANSACCION RECHAZADA",
         "wRESPUESTA_LARGA": "001|MEDICAMENTO NO CUBRE"
      }]
   },
   "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
   "jsonrpc": "2.0"
}
    
]


/**Response Doctor***/

[
    {
   "result":    {
      "status":       {
         "codRespuesta": 0,
         "desRespuesta": "Llave activa."
      },
      "doctor":       [
                  {
            "COD_DOCTOR": "11019",
            "NOM_DOCTOR": "[no_ars] - TOMAS JUAN ELIAS PEREZ VARGAS"
         },
                  {
            "COD_DOCTOR": "31497",
            "NOM_DOCTOR": "[no_ars] - THELMA JUANINA ALTG. GUZMAN QUEZADA"
         },
                  {
            "COD_DOCTOR": "13225",
            "NOM_DOCTOR": "[no_ars] - SOL JUANA INES FELIZ URBAEZ"
         },
                  {
            "COD_DOCTOR": "36779",
            "NOM_DOCTOR": "[no_ars] - SOCRATES ANALDO JOSE JUAN COSME ANGELES"
         },
                  {
            "COD_DOCTOR": "28932",
            "NOM_DOCTOR": "[no_ars] - SILVIA JUANA FELIZ GARCIA"
         },
                  {
            "COD_DOCTOR": "14356",
            "NOM_DOCTOR": "[no_ars] - SERGIA JUANA SANTOS CASTILLO"
         },
                  {
            "COD_DOCTOR": "29016",
            "NOM_DOCTOR": "[no_ars] - ROSANNA JUANES DE LA CRUZ MENDEZ"
         }
      ]
   },
   "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
   "jsonrpc": "2.0"
}
    
]

/**Response doctor error*/
[
    {
       "error":    {
          "code": -32602,
          "message": "nomDoctor: Por favor, introduzca al menos 3 caracteres.",
          "data": {}
       },
       "id": "03713e7dd86c3d7be9d4fba47a62c3b877fee5d7",
       "jsonrpc": "2.0"
    }
]