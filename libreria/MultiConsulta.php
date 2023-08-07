<?php

class MultiConsulta {

    const HOST = "172.168.251.200";
    const USER = 'webroot';
    const PASSWORD = 'An2980616';
    const DB = 'MEDICAMENTO';

    private $cnx;

    public function __construct() {

//        try {

            $this->init();
            
//        } catch (mysqli_sql_exception $e) {
//
//            throw $e;
//        }
    }

    /**
     * Inicia la conexion
     */
    private function init() {

        $this->cnx = new mysqli(
                self::HOST, self::USER, self::PASSWORD, self::DB
        );

        $this->cnx->set_charset('utf8');
    }

    /**
     * Realiza la consulta y retorna mas de un arreglo 
     * @param type $query
     * @return type
     */
    public function consultaMultipleResultado($query) {
        // nuestro ResultSet
        $RS = array();
        // ¿Se ejecutó correctamente?
        if ($this->cnx->multi_query($query)) {
            do {
                // ¿Hay datos?
                if ($result = $this->cnx->store_result()) {
                    // Un DataSet
                    $DS = array();
                    // Copiamos datos:
                    while ($row = $result->fetch_assoc()) {
                        $DS[] = $row;
                    }
                    // Añadimos el DataSet al ResultSet
                    $RS[] = $DS;
                    // Liberamos resultado intermedio:
                    $result->close();
                }
                // ¿Quedan datos?
            } while ($this->cnx->more_results() && $this->cnx->next_result());
        }
        // Devolvemos el ResultSet con los DataSet
        return $RS;
    }

    /**
     * Limpia cualquier parametro malisioso
     * @param type $param
     * @return type
     */
    protected function realScapeString($param) {
        return $this->cnx->real_escape_string($param);
    }

    /**
     * Devuelve la instancia creada
     * @return type
     */
    public function getObjeto() {
        return $this->cnx;
    }

    /**
     * Cierra la conexion y elimina el thread
     */
    private function cerrar() {
        $id_hilo = $this->cnx->thread_id;

        /* Destruir la conexión */
        $this->cnx->kill($id_hilo);

        $this->cnx->close();

//         LogMedinetRest::log("Destruyendo :<pre></pre>");
    }

    public function __destruct() {
        $this->cerrar();
    }

}
