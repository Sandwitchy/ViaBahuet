<?php
  class Controller
  {
    private $conn; //chaine de connexion à la BDD


    public function Controller($conn="")

    {
      $this->conn = $conn;
    }
    /**
    GETTER
    **/
    public function get_conn()
    {
      return $this->conn;
    }
    /**
    SETTER
    **/
    public function set_conn($conn)
    {
      $this->conn = $conn;
    }
    /**
    Fonctions
    **/
    /***************************************************************************
    Execute une requete SQL en SELECT *
    Entrée :
      Nom de la table choisi
    Sortie :
      Resultats de la requete.
    ***************************************************************************/
    public function selectAllTable($Var_nametable)
    {
      $sql_SELECTTABLE = "SELECT * FROM $Var_nametable";
      $conn = $this->get_conn();
      $req_sql = $conn->query($sql_SELECTTABLE);
      $res_sql = $req_sql -> fetchall(PDO::FETCH_ASSOC);
      return $res_sql;
    }
    public function insertBDD($Var_nametable,$tab_value)
    {
      $sql_INSERTTABLE = "INSERT INTO $Var_nametable";

      $i = 0;
      foreach ($tab_value as $var_tabLine)
      {
        if ($i == 0)
        {
          $sql_INSERTTABLE = $sql_INSERTTABLE." VALUES('".$var_tabLine."'";
          $i = 1;
        }
        else
        {
          $sql_INSERTTABLE = $sql_INSERTTABLE.",'".$var_tabLine."'";
        }
      }
      $sql_INSERTTABLE = $sql_INSERTTABLE.')';
      $conn = $this->get_conn();
      $req_sql = $conn->query($sql_INSERTTABLE);
    }
    //Fonction de connexion Utilisateur
    /*
      Entré :
        Log
        pass
      Sortie :
        1 : log n'existe pas
        2 : mot de passe mauvais
        idUser : log & mot de passe bon
    */
    public function connexionVerif($Var_Log,$Var_Pass)
    {
      $conn = $this -> get_conn();
      $Var_Log = $conn -> quote($Var_Log);
      $sql_Verif = "SELECT idUser,mailUser,loginUser,passUser FROM user
                    WHERE mailUser = $Var_Log
                    OR loginUser = $Var_Log";
      $req_SQL = $conn -> query($sql_Verif);
      if ($req_SQL == FALSE)
      {
        return "FALSE";//erreur le log n'existe pas
      }else
      {
        $res_SQL = $req_SQL -> fetch();
        if($Var_Pass != $res_SQL['passUser'])
        {
          return "FALSE"; //erreur password mauvais
        }else {
          return $res_SQL['idUser']; //réussi
        }
      }

    }

    public function updateBDD($table,$data,$idUser,$conn) //FAIRE UNE FONCTION QUI GENERE PLUSIEURS MODIFICATIONS EN FONCTION DU NOMBRE DE DONNEES
    {
      $SQL_update = "UPDATE $table SET";
      $i = 0;
      foreach($data as $uneData) //Construction de la requête
      {
        $donnee = $conn->quote($uneData['donnee']);
        if($i == 0) //s'il n'y a qu'une donnée, je construis une requête simple
        {
          $SQL_update = $SQL_update." ".$uneData['colonne']."=".$donnee;
          $i++;
        }
        else {
          $SQL_update = $SQL_update." , ".$uneData['colonne']."=".$donnee; //s'il y a plusieurs données, je les ajoute en gérant les virgules dans la RQT
        }
      }
      $SQL_update = $SQL_update." WHERE idUser = $idUser";
      $conn ->query($SQL_update); //je termine la RQT et j'exécute
    }

  }
 ?>