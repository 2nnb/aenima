<?php
class bd
{
	private $host;
	private $nombrebd;
	private $usuario;
	private $clave;
	private $conexion;
	private $resultado;	
	private $estatusTran;
	private $contTran;

	public function bd($nombrebd,$usuario,$clave,$host="localhost",$puerto="5432")
	{
		$this->host=$host;
		$this->nombrebd=$nombrebd;
		$this->usuario=$usuario;
		$this->clave=$clave;
		$this->conexion="";
		$this->resultado="";
		$this->estatusTran=0;
		$this->contTran=0;
	}

	public function conect()
	{
		if ($con=pg_connect("host=".$this->host." port=5432 user=".$this->usuario." password=".$this->clave." dbname=".$this->nombrebd))
			$this->conexion=$con;
		else
			die ("Error al conectar la base de datos");
	}

	public function consult($sql,$data)
	{
		$qry=pg_send_query_params($this->conexion,$sql,$data);
		$reg=pg_get_result($this->conexion);					
		$lista=array();   
		while ($r=pg_fetch_object($reg))		
		      array_push($lista,$r);
		return ($lista);
	}

	public function search($sql,$data)
	{
		$qry=pg_send_query_params($this->conexion,$sql,$data);
		$reg=pg_get_result($this->conexion);
		return (pg_fetch_object($reg));
	}

	public function exist($sql,$data)
	{
		$qry=pg_send_query_params($this->conexion,$sql,$data);
		$reg=pg_get_result($this->conexion);
		if (pg_num_rows($reg)>0)
			return true;
		else
			return false;
	}
	
	public function exist_id($sql,$data)
	{
		$qry=pg_send_query_params($this->conexion,$sql,$data);
		$reg=pg_get_result($this->conexion);
		if (pg_num_rows($reg)>0)
		{
			$r=pg_fetch_array($reg);
			return $r[0];
		}
		else
			return -1;
	}	
	
	public function procedure($sql,$data)
	{
		$qry="";
		$qry=pg_prepare($this->conexion,"SQL",$sql);
		$error=pg_last_error($this->conexion);		
		if ($qry!="")
		{
			$qry=pg_send_query_params($this->conexion,$sql,$data);	
			//$this->register($error." ".$sql,0);			
			return true;	
		}
		else
		{
			//$this->register($sql,1);
			return false;
		}
	}
	
	public function begin_trans()
	{
		pg_query($this->conexion,"BEGIN ");
	}

	public function end_trans()
	{
		if ($this->estatusTran==0)
		{
			pg_query($this->conexion,"COMMIT;");
			return true;
		}
		else			
		{
			pg_query($this->conexion,"ROLLBACK;");				
			return false;
		}
	}
	
	public function trans($sql,$data)
	{
		if ($this->estatusTran==0)
		{
			$this->contTran++;
			$qry="";
			$qry=pg_prepare($this->conexion,"SQL".$this->contTran,$sql);
			$error=pg_last_error($this->conexion);
			if ($qry!="")
			{
				$qry=pg_send_query_params($this->conexion,$sql,$data);					
				//$this->register($error." ".$sql,0);				
				$this->estatusTran=0;
			}
			else
			{
				//$this->register($sql,1);
				$this->estatusTran=1;
			}
		}
	}
	
	private function register($tipo="0",$mensaje="0"){
		if ($_SESSION["sesion"]!=""){
			$mensaje=str_replace("'","",$mensaje);
			$sql_mov="INSERT INTO session (id_session,datetime,operation,observation) VALUES (".$_SESSION["id_sesion"].",current_timestamp,".$tipo.",'".$mensaje."')";
			pg_query($this->conexion,$sql_mov);
		}
	}	
}
?>