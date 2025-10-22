<?php
// autoload.php
// 10 octubre del 2024
// esta funcion elimina el hecho de estar agregando los modelos manualmente


spl_autoload_register(function($modelname){
        if(Model::exists($modelname)){
                include Model::getFullPath($modelname);
        } 
});



?>
