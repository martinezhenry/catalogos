 <? 
  $link1=Conectarse();
  $sqimg= mysql_query("SELECT * FROM img_temp where id_articulo ='$id'",$link1); 
  $imga= mysql_fetch_array($sqimg);
  $imagen=$imga['img'];
  $storage_dir="$imagen$id/peque/";				
  $storage_dirt="$imagen$id/grande/";
 

  chdir($storage_dir);
  
  $imgs = fLeeImg($storage_dir); // definimos un vector de imagenes pequeñas
  $imga = fLeeImg($storage_dirt); // definimos un vector de imagenes grandes 
    
	 $numero=count($imgs)-2;
 
   $mostrar=0; $i=0; $j=0;
    while($i<=$numero) //15 son las 15 imagenes (0...15) que se muestran por pagina
  	{
	$imagen = $imgs[$i];    // 
	$imageG = $imga[$i]; 
    $dimag="$storage_dir$imageG";						
    $dimap="$storage_dirt/$imagen";	
	//$name=explode(.);
	//$name = explode("jpg", $imagen);
	?>

									<ul class="pagination">
										<li><a href="<? // echo " $dimag";?>"><img src="<? echo "$dimap"?>" width="s-img" alt="1144953 3 2x"></a></li>
									<? $i++; 
   $j++;
   echo " </td>";
	if ($j==3){
		echo "</tr>";
		$j=0;
		}
	}?>
                                        <div class="clear"></div>
									
  
</ul>