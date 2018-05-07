<?php
    
    require_once 'vendor/autoload.php';
    require_once 'persona.php';
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    
    
    class personaApi extends persona{
        public function alta($request, $response, $args){        
            $nuevoPersona = new Persona($request->getAttribute('nombre'), $request->getAttribute('apellido'), $request->getAttribute('sexo'), $request->getAttribute('password'));
            return $response->withJson($nuevoPersona->guardarPersona());        
        }

        public function modificar($request, $response, $args){
            $personaModificado = persona::TraerPersona($request->getAttribute('mail'), $request->getAttribute('password'));
            
            if($personaModificado){
                $personaModificado->nombre = $request->getAttribute('nombre');
                $personaModificado->apellido = $request->getAttribute('mail');
                $personaModificado->usuario = $request->getAttribute('sexo');
                
                return $response->withJson($personaModificado->modificarpersona());    
            }
            else{
                return $response->withJson('No existe ningun persona con ese id', 20);
            }
        }
        
        public function borrar($request, $response, $args){
            $mail = filter_var($request->getAttribute('mail'));
            if($mail){
                return $response->withJson(persona::borrarPersona($mail));
            }
            else{
                return $response->withJson("id invalido", 206);
            }
        }


        public static function listaPersonasApi($request, $response, $args){
            $retorno['exito'] = false;
            $personas = persona::Traerpersonas();  
            if(isset($personas)){
                $retorno['exito'] = true;
                $retorno['personas'] = $personas;
            }
            if($retorno['exito']){
                return $response->withJson($retorno);    
            }
            return $response->withJson($retorno, 206 );
        }
    }


?>