<?php
   /*
      Plugin Name: SimpleGMaps
      Plugin URI: www.programacionwebgalicia.com
      Description:  Añade a una zona de tu página un google maps.
      Version: 1.0
      Author: Javier Méndez Veira.
      Author URI: www.programacionwebgalicia.com
   */

/*  Copyright 2007-2012 Takayuki Miyoshi (email: takayukister at gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/



 
   
//Constructor
function SimpleGMaps(){

    
      }

//Métodos Instalación/Desinstalación    
function SimpleGMaps_instala(){
   
}


function SimpleGMaps_desinstala(){

   
}


//Opciones de menú
if (function_exists('add_action')) {
    add_action('admin_menu', 'register_menu_page_simplegmaps');
    add_action('activate_SimpleGMaps/SimpleGMaps.php','SimpleGMaps_instala');
    add_action('deactivate_SimpleGMaps/SimpleGMaps.php', 'SimpleGMaps_desinstala');
}



function register_menu_page_simplegmaps() {
   
   //Item Menú padre
   add_menu_page(__('Simple GMaps'), __('SimpleGMaps'), 'administrator', 'menu-SimpleGMaps', 'Render_SimpleGMaps_Index', plugins_url('SimpleGMaps/images/PWGalicia.png'), 7); 
     
}




 //Página de inicio del plugin en la sección de administración:
function Render_SimpleGMaps_Index() {
	global $title;
	?>
        <h2><?php echo $title;?></h2>
       Para usar SimpleGMaps solo tienes que agregar la etiqueta [simplegmaps] en el contenido de tus páginas, 
       debes indicar las siguientes opciones:
       <br>
       <p> Datos por defecto:
        <ul>
            <li> latitud = "40.430224"</li>
            <li> longitud = "-2.416992"</li>
            <li> zoom = "8"</li>
            <li> tipomapa = "SATELLITE"</li>
            <li> titulomarker = "Aqui estoy!"</li>
            <li> alto = "200px"</li>
            <li> ancho = "300px"</li>
        </ul>
       </p>
       <p>
           Ejemplo: [simplegmaps latitud = "40.430224" longitud = "-2.416992" zoom="13" alto="300px" ancho="300px" titulomarker = "Hola Mundo!"] 
           Crearía un plano con el tamaño y coordenadas indicadas con zoom 13 y con una marker que pondría Hola Mundo!
       </p>
       <br/>
       <p>
            <u>Autor:</u> Javier Méndez<br/>
            <u>Web:</u> <a href="http://www.programacionwebgalicia.com/" TARGET="_blank" > http://www.programacionwebgalicia.com/ </a>  <br/>
            <u>Blog:</u> <a href="http://programacionwebgalicia.wordpress.com/" TARGET="_blank" > http://programacionwebgalicia.wordpress.com/ </a>  <br/>
            <u>Facebook:</u> <a href="https://www.facebook.com/pages/Programaci%C3%B3n-Web-Galicia/206144426132817" TARGET="_blank" > https://www.facebook.com/pages/Programaci%C3%B3n-Web-Galicia/206144426132817 </a>  <br/>
            <u>Twitter:</u> <a href="https://twitter.com/#!/PWGalicia" TARGET="_blank" > https://twitter.com/#!/PWGalicia </a>  <br/>
        </p>
        <?php
}





 //Código generado con la etiqueta [simplegmaps]
//Registramos la librería de google maps y el CSS del plano
function simplegmaps_shortcode($atts = array()) {

 	extract(shortcode_atts(array(                
                'latitud' => '40.430224',
                'longitud' => '-2.416992',
                'zoom' => '8',
                'tipomapa' => 'SATELLITE',
                'titulomarker' => 'Aqui estoy!',
                'alto' => '200px',
                'ancho' => '300px'
                    ), $atts));
        //Agregamos las librerías y CSS que necesitamos
        wp_enqueue_style('SimpleGMapsCSS', plugins_url('SimpleGMaps/css/style.css'));                
		               
 			$return .= '     
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
            <script type="text/javascript">
                
                function initialize() {
                                         
                    var posSimpleGMaps = new google.maps.LatLng(parseFloat(document.getElementById("tbLatitud").value), parseFloat(document.getElementById("tbLongitud").value) );
                    
                    
                    var myOptions = {
                        zoom: parseInt(document.getElementById("tbZoom").value),
                        center:posSimpleGMaps,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,  
	                       streetViewControl:false
						};

                    var map = new google.maps.Map(document.getElementById("map_simpleGMaps"), myOptions);

                    var marker = new google.maps.Marker({
                            position: posSimpleGMaps,                                     
                            map: map,                                   
                            title: document.getElementById("tbTituloMarker").value
                        });
                        
                    var tipoMapa = document.getElementById("tbTipoMapa").value;
                     
                    if(tipoMapa == "SATELLITE")
                        map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
                    if(tipoMapa == "HYBRID")
                        map.setMapTypeId(google.maps.MapTypeId.HYBRID);
                    if(tipoMapa == "TERRAIN")
                        map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
                    if(tipoMapa == "ROADMAP")
                        map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
                        
                }
                
               
                
                google.maps.event.addDomListener(window, "load", initialize);
            </script>
        ';                    
			   
                
                
				$return .= '<div id="map_simpleGMaps" class="simpleGMaps" style="height:'.$alto.';width:'.$ancho.'"></div>';
                $return .= '
                            <input type="hidden" name="tbLatitud" id="tbLatitud" value="'.$latitud.'"/> 
                            <input type="hidden" name="tbLongitud" id="tbLongitud" value="'.$longitud.'"/> 
                            <input type="hidden" name="tbZoom" id="tbZoom" value="'.$zoom.'"/>                            
                            <input type="hidden" name="tbTipoMapa" id="tbTipoMapa" value="'.$tipomapa.'"/>
                            <input type="hidden" name="tbTituloMarker" id="tbTituloMarker" value="'.$titulomarker.'"/>
                                ';
                
               
		return $return;
	}

//Registramos códigos:	
add_shortcode( 'simplegmaps', 'simplegmaps_shortcode' );



?>