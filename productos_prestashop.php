<?php    
//incluimos funciones simples de imagen
include('SimpleImage.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_time_limit(0);

$username = "compunet_ps1";
$password = "qfsd21klzxcv21kl";
$hostname = "localhost"; 

//Conexión con la base de datos
//$dbhandle = mysqli_connect($hostname, $username, $password);
$dbhandle = mysqli_connect($hostname, $username, $password,"compunet_ps1");
//$selected = mysqli_select_db("compunet_ps1",$dbhandle);

function sanear_string($string)
{
 
    $string = trim($string);
 
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array('@', '|', '!', '"',
             '·', '$', '%', '&', '/',
             '(', ')', '?', '¡',
             '¿', '[', '^', '<code>', ']',
             '+', '}', '{', '¨', '´',
             '>', '< ', ';', ',', ':',
             '.', ' '),
        '-',
        $string
    ); 
 
    return $string;
}

//funcion para comprobar si la categoria ya existe en la base de datos
function comprobarLenguajeExistente($dbhandle, $Lenguaje_)
{
  //Comprobar si existe categoria
  $sql = "SELECT id_lang, name FROM ps_lang";
  $result = mysqli_query($dbhandle,$sql);
  //$id_lenguaje = mysqli_num_rows($result);

  while ($row = mysqli_fetch_array($result)) {        
       if(strtolower(sanear_string($row['name'])) == strtolower(sanear_string('Español'))){
          $id_lenguaje = $row['id_lang'];
        }
  }

  //echo "El resultado de la busqueda comprobarCategoriaExistente es ".$id_categoria."</br>";
  return $id_lenguaje;
}

//funcion para generar el name_link_rewrite en ps_manufacture, y realizar comprobacion
function generar_name_rewrite_Marca()
{
  //extrae marcas de ps_manufacturer
  $sql = "SELECT id_manufacturer, name, name_link_rewrite FROM ps_manufacturer";
  $result = mysqli_query($dbhandle,$sql)or die("No se ha ejecturado la sentencia comprobarMarcaExistente");  

  //compruea existencia de  marcas de ps_manufacturer, y genera el name_link_rewrite
  while ($row = mysqli_fetch_array($result)) {
       //Recogemos el id de la marca en la bd
       if($row['name_link_rewrite'] == '')
       {
         $sql = "UPDATE ps_manufacturer SET 
                              name_link_rewrite = '".strtolower(sanear_string($row['name']))."' 
                              WHERE id_manufacturer  ='".$row['id_manufacturer']."'";
        $res = mysqli_query($dbhandle,$sql);                              
       }       
  }
}

//funcion para comprobar si la marca ya existe en la base de datos
function comprobarMarcaExistente($dbhandle,$marca)
{
  //extrae marcas de ps_manufacturer
  $sql = "SELECT id_manufacturer, 
                 name, 
                 name_link_rewrite 
          FROM ps_manufacturer 
          where name_link_rewrite = ''";
  $result_ = mysqli_query($dbhandle,$sql);  

  //compruea existencia de  marcas de ps_manufacturer, y genera el name_link_rewrite
  while ($row = mysqli_fetch_array($result_)) {
       //Recogemos el id de la marca en la bd       
       $sql = "UPDATE ps_manufacturer SET 
               name_link_rewrite = '".strtolower(sanear_string($row['name']))."' 
               WHERE id_manufacturer  ='".$row['id_manufacturer']."'";
       $result = mysqli_query($dbhandle,$sql);                                     
  }

  $id_lenguaje = comprobarLenguajeExistente($dbhandle,'Español');

  //miramos si existe su marca
  $sql = "SELECT id_manufacturer 
          FROM ps_manufacturer 
          WHERE name_link_rewrite 
          LIKE '%".strtolower(sanear_string($marca))."%' LIMIT 1";          
  $result = mysqli_query($dbhandle,$sql);

  $num_row_marca = mysqli_num_rows($result);

  if($num_row_marca>0){
      $row = mysqli_fetch_array($result);
      //Recogemos el id de la marca en la bd
      $id_fabricante = $row['id_manufacturer'];       
  }else{
      $sql = "INSERT INTO ps_manufacturer (
              id_manufacturer ,
              name ,
              date_add ,
              date_upd ,
              active)";
      $sql .= " VALUES (
              NULL , 
              '".$marca."', 
              '".date("Y-m-d H:i:s")."', 
              '".date("Y-m-d H:i:s")."', 
              '1');";
      $result = mysqli_query($dbhandle,$sql);
      
      $id_fabricante = mysqli_insert_id($dbhandle);             

      $sql = "INSERT INTO ps_manufacturer_lang 
              (
              id_manufacturer ,
              id_lang
              )";
      $sql .= " VALUES 
              ('".$id_fabricante."' , 
              '".$id_lenguaje."'
              );";
      $result = mysqli_query($dbhandle,$sql);                              

      $sql = "INSERT INTO ps_manufacturer_shop 
              (
              id_manufacturer ,
              id_shop
              )";
      $sql .= " VALUES 
              ('".$id_fabricante."' , 
              '1'
              );";
      $result = mysqli_query($dbhandle,$sql);                              
  }

  //echo "El resultado de la busqueda comprobarMarcaExistente es ".$id_fabricante."</br>";
  return $id_fabricante;
}

//funcion que genera y coloca en el directorio correspondiente
//los diferentes tamaños de imagen que usa prestashop
function save_img($url_image,$id_image){
  $array_id_image = str_split($id_image);
  $num_digits = strlen($id_image);  

  $array_img_tag = array("cart_default", "small_default", "medium_default", "home_default", "large_default", "thickbox_default");
  $array_img_px = array("80", "98", "125", "250", "458", "800");  
  
  $image = new SimpleImage(); 
  $dir="img/p/";
  @mkdir("img", 0775);
  @mkdir("img/p", 0775);
  foreach ($array_id_image as $id) {    
    $dir .= $id.'/';
    if(!file_exists($dir)){@mkdir($dir, 0775);}else{chmod($dir, 0775);}
  }  
       
  $files = scandir($dir); // Devuelve un vector con todos los archivos y directorios
  //$ficherosEliminados = 0;
  
  if(count($files)>0){
    foreach($files as $f){
     if (is_file($dir.$f)) {
        if (unlink($dir.$f) ){
           //$ficherosEliminados++;
         }
      }
    }
  }
  
  $imagen_url = file_get_contents($url_image);
  file_put_contents($dir."/".$id_image.'.jpg', $imagen_url);
    
  //recibe_imagen($url_image,$dir.$id_image.".jpg");
  //save_img_url($url_image);

  //$image->load($dir.$id_image.".jpg"); 
  //$image->save($dir.$id_image.".jpg");   

  for($i = 0; $i < count($array_img_tag); ++$i) {      
    $image->load($dir.$id_image.".jpg"); 
    $image->resizeToWidth($array_img_px[$i]); 
    $image->save($dir.$id_image."-".$array_img_tag[$i].".jpg"); 
  }    
}

function saveFtpFile( $targetFile = null, $sourceFile = null, $ftpuser = null, $ftppassword = null ){ 
// function settings
$timeout = 50;
$fileOpen = 'w';
 
$curl = curl_init();
$file = fopen (dirname(__FILE__) . '/'.$targetFile, $fileOpen);
curl_setopt($curl, CURLOPT_URL, $sourceFile); 
curl_setopt($curl, CURLOPT_USERPWD, $ftpuser.':'.$ftppassword);
 
  // curl settings
  curl_setopt($curl, CURLOPT_FAILONERROR, 1);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl, CURLOPT_FILE, $file); 
 
  $result = curl_exec($curl);
  $info = curl_getinfo($curl);
 
  curl_close($curl);
  fclose($file);  

  return $result; 
}

function minutos_transcurridos($fecha_i,$fecha_f)
{
  $minutos = ceil((strtotime($fecha_i)-strtotime($fecha_f))/60);  
  return $minutos;
}

mysqli_query($dbhandle,"SET NAMES 'utf8'");

$file = fopen("PRESTASHOP.txt", "w");
fwrite($file,date("d-m-Y H:i:s")." 1 >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>".PHP_EOL);
fwrite($file,"--Inicio---------------------------------------------------------------".PHP_EOL);
fwrite($file, "PROCESO ftp: ".date("d-m-Y H:i:s").PHP_EOL);
fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
fwrite($file,PHP_EOL.PHP_EOL);
fclose($file);

$targetFile = 'productos.xml';
$sourceFile = 'ftp://216.70.82.104/catalogo_xml/productos.xml';
$ftpuser = 'PAZ0006';
$ftppassword = 'Compunet10011997';
 
if(saveFtpFile( $targetFile, $sourceFile, $ftpuser, $ftppassword ))
{  
  $filename = "productos.xml";
  //$handle = fopen($filename, "r");
  //$contents = fread($handle, filesize($filename));
  //fclose($handle);
  //$contents = str_replace(" & " , " ", $contents);

  //if (is_writable($filename)) {
    
   //if ($handle = fopen($filename, 'w+')) {
        
    //if (fwrite($handle, $contents) === FALSE) {

      //echo "Error al cambiar caracteres.";
          
    //}
    //else
    //{ 
          //fclose($handle);  

          $xml=simplexml_load_file($filename);        
          
          $sql = "DELETE FROM productosXMLoriginal";
          $result = mysqli_query($dbhandle,$sql);    
          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"-- Inicio 2 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO productosXMLoriginal: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);         
          foreach ($xml->children() as $childre) {             
                                    $almacen=0;$precio_mayoreo=0;$porcentaje=0;$porcentaje_aplicar=0;$precio_venta=0;

                                    $almacen = $childre->existencia->HMO+$childre->existencia->DFA+$childre->existencia->PAZ+$childre->existencia->GDL;
                                    $precio_mayoreo = floatval($childre->precio) * floatval($childre->tipo_cambio);
                                    $porcentaje = 0;

                                    $especificaciones = array();

                                    if(isset($childre->especificacion->caracteristica1)){
                                    	$tipo=$childre->especificacion->caracteristica1->tipo;
                                    	$valor=$childre->especificacion->caracteristica1->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica2)){
                                    	$tipo=$childre->especificacion->caracteristica2->tipo;
                                    	$valor=$childre->especificacion->caracteristica2->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica3)){
                                    	$tipo=$childre->especificacion->caracteristica3->tipo;
                                    	$valor=$childre->especificacion->caracteristica3->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica4)){
                                    	$tipo=$childre->especificacion->caracteristica4->tipo;
                                    	$valor=$childre->especificacion->caracteristica4->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica5)){
                                    	$tipo=$childre->especificacion->caracteristica5->tipo;
                                    	$valor=$childre->especificacion->caracteristica5->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica6)){
                                    	$tipo=$childre->especificacion->caracteristica6->tipo;
                                    	$valor=$childre->especificacion->caracteristica6->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica7)){
                                    	$tipo=$childre->especificacion->caracteristica7->tipo;
                                    	$valor=$childre->especificacion->caracteristica7->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    if(isset($childre->especificacion->caracteristica8)){
                                    	$tipo=$childre->especificacion->caracteristica8->tipo;
                                    	$valor=$childre->especificacion->caracteristica8->valor;
                                    	$especificaciones[] =array('tipo'=>$tipo,'valor'=>$valor);                                    	                                    	
                                    }

                                    $sql = "SELECT ps_category_lang_porcentaje as porcentaje
                                            FROM ps_category_lang as pcl
                                            WHERE LOWER(pcl.name_rewrite) LIKE '".strtolower(sanear_string($childre->subcategoria))."'";
                                    $result = mysqli_query($dbhandle,$sql);  
                                    $num_row = mysqli_num_rows($result);

                                    if($num_row>0){
                                      $row = mysqli_fetch_array($result);
                                      $porcentaje = $row['porcentaje'];
                                    }else{
                                      $sql = "SELECT porciento as porcentaje
                                            FROM categoriasPORCIENTO as pcl
                                            WHERE LOWER(pcl.nombre_categoria_rewrite) LIKE '".strtolower(sanear_string($childre->subcategoria))."'";
                                      $result = mysqli_query($dbhandle,$sql);  
                                      $num_row = mysqli_num_rows($result);
                                      if($num_row>0){
                                        $row = mysqli_fetch_array($result);
                                        $porcentaje = $row['porcentaje'];
                                      }else{                                    
                                            $sql = "SELECT pncu.porciento as porcentaje
                                            FROM productosnewCategoryupdate as pncu
                                            WHERE LOWER(pncu.subcategoria) LIKE '".strtolower($childre->subcategoria)."' or 
                                                  LOWER(pncu.subcategoria_rewrite) LIKE '".strtolower(sanear_string($childre->subcategoria))."' or
                                                  LOWER(pncu.subcategoria_ps) LIKE '".strtolower($childre->subcategoria)."'";      
                                            $result = mysqli_query($dbhandle,$sql);  
                                            $num_row = mysqli_num_rows($result);
                                            if($num_row>0){
                                              $row = mysqli_fetch_array($result);
                                              $porcentaje = $row['porcentaje'];
                                            }   
                                      }  
                                    }

                                    if($porcentaje=='' || $porcentaje == NULL || $porcentaje == 0)
                                    {
                                      $porcentaje=25;
                                    }

                                    $porcentaje_aplicar = 1+floatval($porcentaje/100);

                                    $precio_venta = floatval($precio_mayoreo)*floatval($porcentaje_aplicar);                              

                                    $descripcioncorta2 = "# Parte: ".$childre->no_parte.
                                                         "<br\>"."Modelo: ".$childre->modelo."<br\><br\>".
                                                          mysqli_real_escape_string($dbhandle,$childre->descripcion_corta)."<br\><br\>".
                                                          "La Paz (Entrega Dia Siguiente): ".$childre->existencia->PAZ." Pzas<br\>".
                                                          "Hermosillo (Entrega 1 a 7 Dias): ".$childre->existencia->HMO." Pzas<br\>".
                                                          "CDMX (Entrega 1 a 7 Dias): ".$childre->existencia->DFA." Pzas<br\>".
                                                          "Guadalajara (Entrega 1 a 7 Dias): ".$childre->existencia->GDL." Pzas<br\><br\>".
                                                          "##".strtolower(sanear_string($childre->subcategoria))."##".$porcentaje."##";                                         

                                    
                                    if($almacen > 0){$active=1;}else{$active=0;}

                                    //if($childre->descripcion==''){
                                       //$childre->descripcion = mysqli_real_escape_string(file_get_contents($childre->nueva_desc));
                                    //}

                                    $sql = "INSERT INTO productosXMLoriginal (
                                      id,
                                      clave ,
                                      no_parte ,
                                      nombre ,
                                      nombre2 ,
                                      modelo ,
                                      marca ,
                                      categoria ,
                                      subcategoria ,
                                      descripcion,
                                      nueva_des ,
                                      imagen ,
                                      descripcion_corta ,
                                      upc ,
                                      status,
                                      sustituto,
                                      precio ,
                                      moneda ,
                                      tipo_cambio ,
                                      HMO ,
                                      DFA,
                                      PAZ,
                                      GDL,
                                      categoria_rewrite,
                                      Almacen,
                                      Precio_Mayoreo,
                                      porcentaje,
                                      Porcentaje_Aplicar,
                                      precio_venta,
                                      descripcion_corta2,
                                      active,
                                      caracteristicas)";
                                    $sql .= " VALUES (
                                      NULL,
                                      '".$childre->clave."', 
                                      '".$childre->no_parte."', 
                                      '".$childre->nombre." ".$childre->marca." ".$childre->modelo."', 
                                      '".$childre->nombre2."', 
                                      '".$childre->modelo."', 
                                      '".$childre->marca."', 
                                      '".$childre->categoria."', 
                                      '".$childre->subcategoria."', 
                                      '".mysqli_real_escape_string($dbhandle,$childre->descripcion)."', 
                                      '".$childre->nueva_des."', 
                                      '".$childre->imagen."', 
                                      '".mysqli_real_escape_string($dbhandle,$childre->descripcion_corta)."', 
                                      '".$childre->upc."', 
                                      '".$childre->status."', 
                                      '".$childre->sustituto."', 
                                      ".$childre->precio.", 
                                      '".$childre->moneda."', 
                                      ".$childre->tipo_cambio.", 
                                      ".$childre->existencia->HMO.", 
                                      ".$childre->existencia->DFA.", 
                                      ".$childre->existencia->PAZ.", 
                                      ".$childre->existencia->GDL.",
                                      '".strtolower(sanear_string($childre->subcategoria))."',                                
                                      ".$almacen.",
                                      ".$precio_mayoreo.",
                                      ".$porcentaje.",
                                      ".$porcentaje_aplicar.",
                                      ".$precio_venta.",
                                      '".$descripcioncorta2."',
                                      ".$active.",
                                      '".json_encode($especificaciones, JSON_FORCE_OBJECT)."');";                              
                                    $res = mysqli_query($dbhandle, $sql);        
          }          

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 3 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE TONERS 15%: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "UPDATE productosXMLoriginal AS xmloriginal
                  SET xmloriginal.porcentaje = 15, 
                  xmloriginal.Porcentaje_Aplicar = 1.15, 
                  xmloriginal.precio_venta = xmloriginal.Precio_Mayoreo*1.15 
                  WHERE xmloriginal.categoria_rewrite LIKE '%toners%'";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 3.1 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE LAPTOPS 20%: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);

          $sql = "UPDATE productosXMLoriginal AS xmloriginal
                  SET xmloriginal.porcentaje = 20, 
                  xmloriginal.Porcentaje_Aplicar = 1.20, 
                  xmloriginal.precio_venta = xmloriginal.Precio_Mayoreo*1.20 
                  WHERE xmloriginal.categoria_rewrite LIKE '%laptops%' or 
                        xmloriginal.categoria_rewrite LIKE '%laptop%'";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 4 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO PRODUCTOS NUEVOS: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);  

          $sql = "INSERT INTO productosNUEVOS
                  SELECT ALIAS.*
                  FROM
                  (SELECT 
                  newproduct.*
                  FROM 
                  productosXMLoriginal as newproduct 
                  LEFT JOIN
                  ps_product as oldproduct
                  on newproduct.clave = oldproduct.reference 
                  WHERE oldproduct.reference IS NULL) AS ALIAS
                  WHERE ALIAS.clave NOT IN (SELECT clave FROM productosNUEVOS);";
          $result = mysqli_query($dbhandle,$sql);   

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 5 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE PRECIOS ps_product: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "UPDATE ps_product AS psproduct_update, 
                         (SELECT
                            product_XML.Precio_Mayoreo AS preciomayoreo,
                            product_XML.precio_venta AS precioventa,          
                            product_XML.no_parte AS noparte,
                            product_XML.active AS active,          
                            psproduct.id_product AS idproducto          
                          FROM
                            ps_product AS psproduct INNER JOIN 
                            productosXMLoriginal AS product_XML ON product_XML.clave = psproduct.reference
                         ) AS product_xml_select
                  SET psproduct_update.price = product_xml_select.precioventa, 
                      psproduct_update.wholesale_price = product_xml_select.preciomayoreo,
                      psproduct_update.noparte = product_xml_select.noparte,
                      psproduct_update.active = product_xml_select.active     
                  WHERE psproduct_update.id_product = product_xml_select.idproducto";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 6 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE PRECIOS ps_product_shop: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "UPDATE ps_product_shop AS psproduct_shop_update, 
                         (SELECT
                            product_XML.Precio_Mayoreo AS preciomayoreo,
                            product_XML.precio_venta AS precioventa,    
                            product_XML.active AS active,
                            psproduct.id_product AS idproducto          
                          FROM
                            ps_product AS psproduct INNER JOIN 
                            productosXMLoriginal AS product_XML ON product_XML.clave = psproduct.reference
                         ) AS product_xml_select
                  SET psproduct_shop_update.price = product_xml_select.precioventa, 
                      psproduct_shop_update.active = product_xml_select.active , 
                      psproduct_shop_update.wholesale_price = product_xml_select.preciomayoreo
                  WHERE psproduct_shop_update.id_product = product_xml_select.idproducto";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 7 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE DATOS ps_product_lang: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "UPDATE ps_product_lang AS psproduct_lang_update, 
                         (SELECT                      
                            product_XML.nombre AS nombre,          
                            product_XML.descripcion_corta2 AS descripcioncorta,                    
                            product_XML.imagen AS imagen,                    
                            psproduct.id_product AS idproducto          
                          FROM
                            ps_product AS psproduct INNER JOIN 
                            productosXMLoriginal AS product_XML ON product_XML.clave = psproduct.reference
                         ) AS product_xml_select
                  SET psproduct_lang_update.name = 
                      IF(LOCATE('._.', psproduct_lang_update.name)>0 
                      ,psproduct_lang_update.name
                      ,product_xml_select.nombre
                      ),
                      psproduct_lang_update.link_image = product_xml_select.imagen,
                      psproduct_lang_update.description_short = 
                      IF(description_short=null
                          ,descripcioncorta
                          ,CONCAT(SUBSTR(description_short FROM 1 for LOCATE('La Paz', description_short)-1),
                                  SUBSTR(descripcioncorta FROM LOCATE('La Paz', descripcioncorta) for LENGTH(descripcioncorta))
                                 )
                          )
                  WHERE psproduct_lang_update.id_product = product_xml_select.idproducto";
          $result = mysqli_query($dbhandle,$sql);

          $sql = "UPDATE ps_product_lang AS psproduct_lang_update, 
                         (SELECT
                            product_XML.descripcion AS descripcion,                      
                            psproduct.id_product AS idproducto          
                          FROM
                            ps_product AS psproduct INNER JOIN 
                            productosXMLoriginal AS product_XML ON product_XML.clave = psproduct.reference
                         ) AS product_xml_select
                  SET psproduct_lang_update.description = product_xml_select.descripcion                 
                  WHERE psproduct_lang_update.id_product = product_xml_select.idproducto AND 
                        psproduct_lang_update.description = ''";
          $result = mysqli_query($dbhandle,$sql);        

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 8.2 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO INSERT CATEGORY NEW: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "INSERT INTO productosnewCategoryupdate (subcategoria_rewrite, subcategoria)
                  SELECT ALIAS2.*
                  FROM
                  (SELECT ALIAS.* 
                  FROM (SELECT DISTINCT categoria_rewrite as subcategoria_rewrite, subcategoria FROM productosXMLoriginal) AS ALIAS
                  WHERE ALIAS.subcategoria_rewrite NOT IN (SELECT categoriasPORCIENTO.nombre_categoria_rewrite FROM categoriasPORCIENTO) AND
                        ALIAS.subcategoria_rewrite NOT IN (SELECT productosnewCategoryupdate.subcategoria_rewrite FROM productosnewCategoryupdate)) AS ALIAS2";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 8 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO UPDATE STOCK ps_stock_available: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "UPDATE ps_stock_available AS psstock, 
                         (SELECT
                            product_XML.Almacen AS almacen,          
                            psproduct.id_product AS idproducto          
                          FROM
                            ((ps_stock_available AS stock INNER JOIN 
                            ps_product AS psproduct ON stock.id_product = psproduct.id_product) INNER JOIN 
                            productosXMLoriginal AS product_XML ON product_XML.clave = psproduct.reference)
                         ) AS product_xml_select
                  SET psstock.quantity = product_xml_select.almacen
                  WHERE psstock.id_product = product_xml_select.idproducto";
          $result = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 8.1 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO CARACTERISTICAS PS_FEATURE: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);     

          $sql = "SELECT clave, caracteristicas FROM productosXMLoriginal";
          $result_caracteristicas = mysqli_query($dbhandle,$sql);

          $id_lenguaje = comprobarLenguajeExistente($dbhandle,'Español');
          while ($productos_caracteristicas = mysqli_fetch_array($result_caracteristicas)){ 
            $sql = "SELECT id_product FROM ps_product where reference = '".$productos_caracteristicas['clave']."'";
            $result = mysqli_query($dbhandle,$sql);  
            $num_row = mysqli_num_rows($result);
            if($num_row>0){
                      $row = mysqli_fetch_array($result);
                      $idproduct = $row['id_product']; 

                      $caracteristicas = json_decode($productos_caracteristicas['caracteristicas'],true);
                      $index_position=0;
                      foreach($caracteristicas as $caracteristica){

                        $sql = "INSERT INTO ps_feature (position) VALUES (".$index_position.")";
                        $result_caracteristicas = mysqli_query($dbhandle,$sql);

                        $id_caracteristica = mysqli_insert_id($dbhandle);  
                        $index_position++;                       

                        $sql = "INSERT INTO ps_feature_lang 
                                (id_feature, id_lang, name) 
                                VALUES 
                                (".$id_caracteristica.",".$id_lenguaje.",'".$caracteristica['tipo']."')";
                        $result_caracteristicas_lenguaje = mysqli_query($dbhandle,$sql);

                        $sql = "INSERT INTO ps_feature_value (id_feature, custom) VALUES (".$id_caracteristica.",0)";
                        $result_caracteristicas = mysqli_query($dbhandle,$sql);

                        $id_caracteristica_valor = mysqli_insert_id($dbhandle);                          

                        $sql = "INSERT INTO ps_feature_value_lang 
                                (id_feature_value, id_lang, value) 
                                VALUES 
                                (".$id_caracteristica_valor.",".$id_lenguaje.",'".$caracteristica['valor']."')";
                        $result_caracteristicas_valor_lenguaje = mysqli_query($dbhandle,$sql);

                        $sql = "INSERT INTO ps_feature_product 
                                (id_feature, id_product, id_feature_value) 
                                VALUES 
                                (".$id_caracteristica.",".$idproduct.",'".$id_caracteristica_valor."')";
                        $result_caracteristicas_producto = mysqli_query($dbhandle,$sql);

                        $sql = "INSERT INTO ps_feature_shop 
                                (id_feature, id_shop) 
                                VALUES 
                                (".$id_caracteristica.",1)";
                        $result_caracteristicas_tienda = mysqli_query($dbhandle,$sql);
                      }                     
            }
          }

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 9 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "PROCESO INSERT PRODUCTOS NUEVOS productosNUEVOS: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,PHP_EOL.PHP_EOL);
          fclose($file);

          $sql = "SELECT * FROM productosNUEVOS where producto_insert = 0 or producto_insert is null";
          $result_pn = mysqli_query($dbhandle,$sql);

          while ($productos_nuevos = mysqli_fetch_array($result_pn)){ 

                                        $sql = "SELECT id_category as idcategory
                                                FROM ps_category_lang as pcl
                                                WHERE LOWER(pcl.name_rewrite) LIKE '".strtolower(sanear_string($productos_nuevos['subcategoria']))."'";
                                        $result = mysqli_query($dbhandle,$sql);  

                                        $num_row = mysqli_num_rows($result);

                                        if($num_row>0){
                                          $row = mysqli_fetch_array($result);
                                          $idcategory = $row['idcategory'];
                                        }else{
                                          $sql = "SELECT id_category as idcategory
                                                FROM categoriasPORCIENTO as pcl
                                                WHERE LOWER(pcl.nombre_categoria_rewrite) LIKE '".strtolower(sanear_string($productos_nuevos['subcategoria']))."'";
                                          $result = mysqli_query($dbhandle,$sql);  

                                          $num_row = mysqli_num_rows($result);

                                          if($num_row>0){
                                            $row = mysqli_fetch_array($result);
                                            $idcategory = $row['idcategory'];
                                          }else{
                                            $sql = "SELECT id_category as idcategory
                                                FROM productosnewCategoryupdate as pcl
                                                WHERE LOWER(pcl.subcategoria_rewrite) LIKE '".strtolower(sanear_string($productos_nuevos['subcategoria']))."'";
                                            $result = mysqli_query($dbhandle,$sql);  

                                            $num_row = mysqli_num_rows($result);

                                            if($num_row>0){
                                              $row = mysqli_fetch_array($result);
                                              $idcategory = $row['idcategory'];
                                            }else{
                                              $idcategory = 2;
                                            }  
                                           }                                     
                                        }

                                        if(empty($idcategory)){$idcategory = 2;}

                                        $id_marca = comprobarMarcaExistente($dbhandle,$productos_nuevos['marca']);

                                        $sql = "INSERT INTO ps_product 
                                          (ps_product.id_product ,
                                           id_supplier ,
                                           id_manufacturer,
                                           id_category_default,
                                           id_shop_default,
                                           id_tax_rules_group,
                                           on_sale,
                                           minimal_quantity,
                                           price,
                                           wholesale_price,
                                           reference,
                                           out_of_stock,                                 
                                           ps_product.condition,
                                           ps_product.visibility,
                                           show_price,
                                           indexed,
                                           date_add ,
                                           date_upd ,
                                           active)";

                                        $sql .= " VALUES 
                                          (NULL , 
                                           '0',
                                           '".$id_marca."',
                                           '".$idcategory."',
                                           '1',
                                           '11',
                                           '0',
                                           '1',                                 
                                           '".$productos_nuevos['precio_venta']."',
                                           '".$productos_nuevos['Precio_Mayoreo']."',
                                           '".$productos_nuevos['clave']."',
                                           '2',
                                           'new',
                                           'both',
                                           '1',
                                           '1',
                                           '".date("Y-m-d H:i:s")."', 
                                           '".date("Y-m-d H:i:s")."', 
                                           ".$productos_nuevos['active'].");";
                                        $res = mysqli_query($dbhandle,$sql);

                                        $id_producto = mysqli_insert_id($dbhandle);                
                                        
                                        $id_lenguaje = comprobarLenguajeExistente($dbhandle,'Español');

                                        $sql = "SELECT                                         
                                                MAX(position)+1 as position 
                                                FROM ps_category_product 
                                                WHERE id_category = '".$idcategory."'
                                                GROUP BY id_category";
                                            
                                        $res = mysqli_query($dbhandle,$sql);

                                        $position = mysqli_fetch_array($res);
                                        
                                        $sql = "INSERT INTO ps_category_product 
                                          (id_category ,
                                           id_product,
                                           position)";
                                        $sql .= " VALUES 
                                          ('".$idcategory."' , 
                                           '".$id_producto."',
                                           '".$position['position']."');";
                                        $res = mysqli_query($dbhandle,$sql);

                                        $sql = "INSERT INTO ps_product_lang 
                                          (id_product ,
                                           id_shop,
                                           id_lang ,
                                           description,
                                           description_short,
                                           link_rewrite,
                                           name)";
                                          $sql .= " VALUES 
                                          ('".$id_producto."' , 
                                            '1',
                                            '".$id_lenguaje."',
                                            '".$productos_nuevos['descripcion']."',
                                            '".$productos_nuevos['descripcion_corta2']."',
                                            '".strtolower(sanear_string($productos_nuevos['nombre2']))."',
                                            '".$productos_nuevos['nombre2']."');";
                                        $res = mysqli_query($dbhandle,$sql);

                                        $sql = "INSERT INTO ps_stock_available 
                                          (id_stock_available,
                                           id_product ,
                                           id_product_attribute ,
                                           id_shop ,
                                           id_shop_group ,
                                           quantity ,
                                           depends_on_stock)";
                                          $sql .= " VALUES 
                                          (NULL ,
                                           '".$id_producto."', 
                                           '0',
                                           '1',
                                           '0',
                                           '".$productos_nuevos['Almacen']."',
                                           '0');";                                
                                        $res = mysqli_query($dbhandle,$sql);

                                        $sql = "INSERT INTO ps_product_shop 
                                          (id_product,
                                           id_category_default,
                                           id_shop,
                                           id_tax_rules_group,
                                           on_sale,
                                           price,
                                           wholesale_price,
                                           available_for_order,
                                           ps_product_shop.condition,
                                           ps_product_shop.visibility,
                                           show_price,
                                           indexed,
                                           active,
                                           date_add ,
                                           date_upd )";
                                          $sql .= " VALUES 
                                          ('".$id_producto."',
                                            '".$idcategory."',
                                            '1',
                                            '11',
                                            '0',
                                            '".$productos_nuevos['precio_venta']."',
                                            '".$productos_nuevos['Precio_Mayoreo']."',
                                            '1',
                                            'new',
                                            '1',
                                            '1',
                                            '1',
                                            '".$productos_nuevos['active']."',
                                            '".date("Y-m-d H:i:s")."', 
                                            '".date("Y-m-d H:i:s")."');";
                                        $res = mysqli_query($dbhandle,$sql);

                                        $string_url = $productos_nuevos['imagen'];
                                        $string_url2 = str_replace('http://','http://static.',$productos_nuevos['imagen']);
                                        $string_url2 = str_replace('.jpg','_200.jpg',$string_url2);      

                                        $ban_url=true;

                                        try{

                                            if(file_exists($string_url))
                                            {      
                                                $string_url=$string_url;
                                            }
                                            else
                                            { 
                                              if(file_exists($string_url2))
                                                {
                                                 $string_url=$string_url2;
                                                }
                                              else
                                                {
                                                 $ban_url=false;
                                                }
                                            }   

                                        }catch (Exception $e){
                                          $ban_url=false;
                                        }                           
                                        
                                        if($ban_url){
                                              //Ahora se crean las imagenes del producto
                                              $sql = "INSERT INTO ps_image (id_image,id_product,position,cover)";
                                              $sql .= " VALUES (NULL ,'".$id_producto."', '1','1');";
                                              $res = mysqli_query($dbhandle,$sql);  

                                              $id_image = mysqli_insert_id($dbhandle);

                                              $sql = "INSERT INTO ps_image_shop (id_product,id_image,id_shop,cover)";
                                              $sql .= " VALUES ('".$id_producto."','".$id_image."' ,'1','1');";                                
                                              $res = mysqli_query($dbhandle,$sql);

                                              $sql = "INSERT INTO ps_image_lang (id_image,id_lang)";
                                              $sql .= " VALUES (". $id_image." ,".$id_lenguaje.");";
                                              $res = mysqli_query($dbhandle,$sql);                                   

                                              save_img($string_url,$id_image);       

                                              $sql = "UPDATE ps_product_lang SET 
                                                                      status_image = '1',
                                                                      link_image = '".$string_url."' 
                                                                      WHERE id_product  ='".$id_producto."'";
                                              $res = mysqli_query($dbhandle,$sql);                                    

                                              $sql = "INSERT INTO status_img_add (url_img,noparte,reference,status,fechahora)";
                                              $sql .= " VALUES ('".$string_url."' ,'".$productos_nuevos['no_parte']."','".$productos_nuevos['clave']."','1',now( ));";
                                              $res = mysqli_query($dbhandle,$sql);

                                              $sql = "INSERT INTO status_img_1_add (url_img,noparte,reference,status,fechahora)";
                                              $sql .= " VALUES ('".$string_url."' ,'".$productos_nuevos['no_parte']."','".$productos_nuevos['clave']."','1',now( ));";
                                              $res = mysqli_query($dbhandle,$sql);                                   

                                        }else{

                                              $sql = "UPDATE ps_product_lang SET 
                                                                      status_image = '0',                              
                                                                      link_image = '".$string_url."' 
                                                                      WHERE id_product  ='".$id_producto."'";
                                              $res = mysqli_query($dbhandle,$sql);      

                                              $sql = "INSERT INTO status_img_add (url_img,noparte,reference,status,fechahora)";
                                              $sql .= " VALUES ('".$string_url."' ,'".$productos_nuevos['no_parte']."','".$productos_nuevos['clave']."','0',now( ));";
                                              $res = mysqli_query($dbhandle,$sql);

                                              $sql = "INSERT INTO status_img_0_add (url_img,noparte,reference,status,fechahora)";
                                              $sql .= " VALUES ('".$string_url."' ,'".$productos_nuevos['no_parte']."','".$productos_nuevos['clave']."','0',now( ));";
                                              $res = mysqli_query($dbhandle,$sql);
                                        }  

                                        $sql = "UPDATE productosNUEVOS SET 
                                                                      producto_insert = '1' 
                                                                      WHERE clave  ='".$productos_nuevos['clave']."'";

                                        $res = mysqli_query($dbhandle,$sql);
          }

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 100  ESACTIVA PRODUCTOS POR MARCA---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "FIN PROCESO: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin ESACTIVA PRODUCTOS POR MARCA------------------------------------------------------------------".PHP_EOL);
          fwrite($file,date("d-m-Y H:i:s")." 10 >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>".PHP_EOL);
          fclose($file);     

          //DESACTIVA PRODUCTOS POR MARCA
          $array_marcas_disabled = array('levydal','aspel');
          
          foreach($array_marcas_disabled as $valor)
          {
              $id_marca = comprobarMarcaExistente($dbhandle,$valor);

              $sql = "UPDATE ps_product as psp, ps_product_shop as psps
                      SET psp.active = 0,
                          psps.active = 0
                      WHERE psp.id_product = psps.id_product and psp.id_manufacturer = ".$id_marca;
              $res = mysqli_query($dbhandle,$sql);
          }

          //ACTUALIZA LOS TONERS QUE NO ESTAN EN ESTOCK
          $sql = "UPDATE ps_product
                  SET ps_product.active = 1     
                  WHERE ps_product.id_category_default IN (429,430,431,432,433,434,439,440,441,442,443)";
          $res = mysqli_query($dbhandle,$sql);
          
          //ACTUALIZA LOS TONERS QUE NO ESTAN EN ESTOCK
          $sql = "UPDATE ps_product_shop
                  SET ps_product_shop.active = 1     
                  WHERE ps_product_shop.id_category_default IN (429,430,431,432,433,434,439,440,441,442,443)";
          $res = mysqli_query($dbhandle,$sql);    

          $file = fopen("PRESTASHOP.txt", "a");
          fwrite($file,"--Inicio 10 ---------------------------------------------------------------".PHP_EOL);
          fwrite($file, "FIN PROCESO: ".date("d-m-Y H:i:s").PHP_EOL);
          fwrite($file,"--Fin------------------------------------------------------------------".PHP_EOL);
          fwrite($file,date("d-m-Y H:i:s")." 10 >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>".PHP_EOL);
          fclose($file);     
          
          $gestor = fopen("PRESTASHOP.txt", "r");
          $contenido = fread($gestor, filesize("PRESTASHOP.txt"));
          echo $contenido;
          fclose($gestor);
     //}
    //}
  //}    

}else{


}




?>