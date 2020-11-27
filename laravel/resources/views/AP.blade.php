
<h4>Instrucciones:</h4>
<style type="text/css">
  .hidden{
    display:none;
  }
</style>
<div id="mostrarOcultar" style=" background-color: #d9ad26" class="hidden">
    <table class="table">
      <caption></caption>
      <thead>
        <tr>
          <th scope="col">Para:</th>
          <th scope="col">Como hacerlo:  </th>
        </tr>
      </thead>  
      <tbody>
        <tr>
          <th scope="row">Ingresar los estados de los autómatas.</th>
          <td>En el recuadro se han de ingresar valores alfanuméricos, letras o números separados por una ",".</td>
        </tr>
        <tr>
          <th scope="row">Ingresar el alfabeto de los autómatas.</th>
          <td>En el recuadro se han de ingresar valores alfanuméricos, letras o números separados por una ",".</td>
        </tr>
        <tr>
          <th scope="row">Ingresar el estado inicial del autómata.</th>
          <td>En el recuadro se ha de ingresar un solo valor el cual corresponde al estado inicial, este debe pertenecer al conjunto de estados ingresado anteriormente.</td>
        </tr>
          <th scope="row">Ingresar las Funciones de transición.</th>
          <td>Será de la forma estado del autómata, alfabeto, estado del autómata, para agregar más de una transición se han de separar por ";", los valores ingresador han de extistir en los estados y en el alfabeto (Para ingresar una conexión vacía tipear un "@" en el apartado del alfabeto "estado,@,estado").</td>
        </tr>
        </tr>
          <th scope="row">Ingresar los Estados Finales de los autómatas.</th>
          <td>Se han de ingresan los estados finales sepadaros mediante una "," y siempre y cuando estos pertenezcan al conjunto de estados. </td>
        </tr>
        </tr>
          <th scope="row">Concatenación de los autómatas.</th>
          <td>Una vez ingresados los autómatas, estos se referenciaran como un "1" para el autómata 1 y 2 respectivamente.</td>
        </tr>
        </tr>
          <th scope="row">Ejemplo de la clase.</th>
          <td>Conjunto de estados: q1,q2,q3,q4,q5 , Alfabeto: a,b, Estado Inicial: q5, Función de transición: q5,a,q4;q5,b,q3;q4,a,q4;q4,b,q2;q3,a,q4;q3,b,q1;q2,a,q4;q2,b,q1;q1,a,q1;q1,b,q1, Estado(s) final(es): q2,q3,q4,q5.</td>
        </tr>
      </tr>
    </tr>
      <th scope="row">Detalles del algoritmo</th>
      <td>Para ver los resultados en detalle (conjunto de estados, alfabeto, estado inicial,  transiciones, estados finales) puede verlos desde la consola haciendo click derecho/inspeccionar elemento en la pestaña console</td>
    </tr>
      </tbody>
    </table>   
</div>
<input type="button" value="Mostrar Instrucciones" onclick="mostrar();">
<input type="button" value="Ocultar Instrucciones" onclick="ocultar();">
<head>
  <title>Automatas | Trabajo Grafos</title>
</head>
<body>
<!doctype html>
<html lang ="en">
<head>
  <title>Network</title>
  <script type="text/javascript" src="https://unpkg.com/vis-network/standalone/umd/vis-network.min.js">
  
  </script> 
  <style type="text/css">
    #mynetwork {
      width: 1111px;
      height: 500px;
      border: 1px solid lightgray;
    }
  </style> 
</head>
<body>
<script> 
        function ocultar(){
          document.getElementById('mostrarOcultar').style.display="none";
        }

        function mostrar(){
          document.getElementById('mostrarOcultar').style.display="block";
        }
</script>
<div id="mynetwork"></div>

<!-- Ingreso de datos automata n°1 visual -->    
</body>
</html> 
<table border="0"> 
  <caption></caption>
  <tr>
    <th scope="col"><h3>Datos Autómatas:</h3></th>
  </tr>
  <tr>
    <td>Conjunto de estados Q:</td>
    <td><input type="text" name="conjuntoQ" placeholder="q1,q2,q3,...,qn" id="Q" > Formato: q1,q2,q3,...,qn </td>
  </tr>
  <tr>
    <td>Alfabeto pila:</td>
    <td><input type="text" name="Alfabetopila" placeholder="x,y,z..." id="Alfabetopila" > Formato: 1,2,3,...,n </td>
  </tr>
  <tr>
    <td>Alfabeto:</td>
    <td><input type="text" name="Alfabeto" placeholder="a,b,c,d,..." id="Alfabeto" > Formato: 1,2,3,...,n </td>
  </tr>
  <tr>
    <td>Estado inicial:</td>
    <td><input type="text" name="Inicial" placeholder="q" id="Inicial" > Formato: q1 </td>
  </tr>
  <tr>
    <td >Función de transición:</td>
    <td ><input type="text" name="Gama" placeholder="q/a/q" id="Gama" > Formato: q1,a,q2;q1,b,q1;...qn,n,qm </td>
  <tr>
    <td>Estado(s) final(es):</td>
    <td><input type="text" name="Finales" placeholder="q1,q2,q3,q4" id="Finales" > Formato: q1,q2,...,qn </td><br>
  </tr>
</table>
<button onclick="ValidarEntrada1()">Ingresar AP 1</button>
<button onclick="ValidarEntrada2()">Ingresar AP 2</button>
<button onclick="reset()">Reset </button>

<br><br>
<table border="	0"> 
  <caption></caption>
  <tr>
    <th scope="col"><h3>Funciones para ambos autómatas</h3> </th> 
  </tr>
<td>	
<button onclick="Union()">Unión</button>
<button onclick="Concatenar()">Concatenación</button>
<input type="text" size="3" name="concatenarinicio" placeholder="inicio" id="Conca1" >
<input type="text" size="3" name="concatenarfinal" placeholder="final" id="Conca2" >
</td>
</table>


<!-- Fin entrada de datos automata n°1 -->


<script type="text/javascript">

var E_inicial1="",E_inicial2="",E_inicialCombi

var AlfabetoP1=[], AlfabetoP2=[], AlfabetoPCombi=[]

var ConjuntoQ1=[],ConjuntoQ2=[],ConjuntoPizarra=[],ConjuntoCombi=[]

var Alfabeto1=[],Alfabeto2=[],AlfabetoCombi=[]

var Gama1=[],Gama2=[],GamaPizarra=[],GamaCombi=[]

var E_Finales1=[],E_Finales2=[],E_FinalesCombi=[]

var node,edge,data,container,options,network


function ValidarEntrada1()
{
    limpiar()

    if(ConjuntoQ1.length>0)
      E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1)

    E_inicial1=document.getElementById("Inicial").value
    var Q=document.getElementById("Q").value
    var A=document.getElementById("Alfabeto").value
    var P=document.getElementById("Alfabetopila").value
    var G=document.getElementById("Gama").value
    var F=document.getElementById("Finales").value

    let valQ=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valP=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valA=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valF=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valG=/^[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+(;[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+)*$/g

    if(Q.length == 0 || A.length == 0 || P.length == 0 || G.length == 0 || E_inicial1.length == 0 || F.length == 0)
        alert("Hay campos en blanco")
    else
    {
        if(valQ.test(Q) && valA.test(A) && valG.test(G) && valF.test(F) && valP.test(P) && caractervalido(E_inicial1))
        {
          ConjuntoQ1=Datos_dupli(Q.split(','))
          Alfabeto1=Datos_dupli(A.split(','))
          E_Finales1=Datos_dupli(F.split(','))
          AlfabetoP1=Datos_dupli(P.split(','))
          Gama1=elemento(Datos_dupli(G.split(';')))
          var idFinales = ids(E_Finales1,ConjuntoQ1)
          var idGama = ids_gama(Gama1,ConjuntoQ1)
          var id_ini=Buscar_id(ConjuntoQ1,E_inicial1)-1
          if(validar_estadosx(ConjuntoQ1,E_inicial1))
          { 
            if(validar_estadosx(ConjuntoQ1,E_Finales1) && validar_gama(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1))
            {
              ConjuntoQ1=cambiarcaracter(ConjuntoQ2,ConjuntoQ1)
              E_inicial1 =  ConjuntoQ1[id_ini]
              E_Finales1 = e_finales(idFinales,ConjuntoQ1)
              Gama1 = gama(idGama,ConjuntoQ1)
              ConjuntoQ1.splice(0,0,E_inicial1)
              ConjuntoQ1=Datos_dupli(ConjuntoQ1)
          

              Gama1=epsilon(Gama1)  

              ConjuntoPizarra=copiararray(ConjuntoQ1,ConjuntoQ2)
              GamaPizarra=copiararray(Gama1,Gama2)
              
              mostrardatos(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1,"A1")

              graph()

              alert(strestados(ConjuntoQ1) +strgama(Gama1))
            }
            else{
              alert("Lo datos ingresados no validos, deben estar contenidos en el alfabeto o en los estados")
              E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1)
            }
          }
          else{
            alert("Lo datos ingresados no validos, el estado inicial debe estar contenido en el conjunto de estados")
            E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1)
          }
        }
        else
          alert("Formato ingresado no valido") 
    }
}

function elemento(arr)
{
  var g=[]
  for(let i=0;i<arr.length;i++)
  {
    var aux=arr[i].split(",")
    g.push(añadirT(aux[0],aux[1].split("/"),aux[2]))
  }
  return g
}

function añadirT(es1,ar,es2)
{
  var r=[]
  r.push(es1)
  for(let i=0;i<ar.length;i++)
    r.push(ar[i])
  r.push(es2)
  return r
}


function ValidarEntrada2()
{
    limpiar()
    if(ConjuntoQ2.length>0){

      E_inicial2=ResetearAutomata(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2)
    }

    E_inicial2=document.getElementById("Inicial").value
    var Q=document.getElementById("Q").value
    var A=document.getElementById("Alfabeto").value
    var P=document.getElementById("Alfabetopila").value
    var G=document.getElementById("Gama").value
    var F=document.getElementById("Finales").value

    let valQ=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valA=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valP=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valF=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valG=/^[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+(;[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+)*$/g

    if(Q.length == 0 || A.length == 0 || G.length == 0 || E_inicial2.length == 0 || P.length==0 || F.length == 0)
        alert("Hay campos en blanco")
    else
    {
        if(valQ.test(Q) && valA.test(A) && valG.test(G) && valF.test(F) && valP.test(P) && caractervalido(E_inicial2))
        {
          ConjuntoQ2=Datos_dupli(Q.split(','))
          Alfabeto2=Datos_dupli(A.split(','))
          AlfabetoP2=Datos_dupli(P.split(","))
          E_Finales2=Datos_dupli(F.split(','))
          Gama2=elemento(Datos_dupli(G.split(';')))
          var idFinales = ids(E_Finales2,ConjuntoQ2)
          var idGama = ids_gama(Gama2,ConjuntoQ2)
          var id_ini=Buscar_id(ConjuntoQ2,E_inicial2)-1
          if(validar_estadosx(ConjuntoQ2,E_inicial2))
          {
            if(validar_estadosx(ConjuntoQ2,E_Finales2) && validar_gama(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2))
            {
              ConjuntoQ2=cambiarcaracter(ConjuntoQ1,ConjuntoQ2)

              E_inicial2 =  ConjuntoQ2[id_ini]
              E_Finales2 = e_finales(idFinales,ConjuntoQ2)
              Gama2 = gama(idGama,ConjuntoQ2)
              ConjuntoQ2.splice(0,0,E_inicial2)
              ConjuntoQ2=Datos_dupli(ConjuntoQ2)
            
          
              Gama2=epsilon(Gama2)
              
              ConjuntoPizarra=copiararray(ConjuntoQ1,ConjuntoQ2)
              GamaPizarra=copiararray(Gama1,Gama2)

              mostrardatos(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2,"A2")

              graph()
              alert(strestados(ConjuntoQ2) +strgama(Gama2))
            }
            else{
              alert("Lo datos ingresados no validos, deben estar contenidos en el alfabeto o en los estados")
              E_inicial2=ResetearAutomata(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2)
            }
          }
          else{
            alert("Lo datos ingresados no validos, el estado inicial debe estar contenido en el conjunto de estados")
            E_inicial2=ResetearAutomata(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2)
          }
        }
        else
          alert("Formato ingresado no valido") 
    }  
}

function reset()
{
  limpiar()
  console.log("Datos borrados.")
  E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1)
  
  E_inicial2=ResetearAutomata(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2)
  
  E_inicialCombi=ResetearAutomata(ConjuntoCombi,AlfabetoCombi,AlfabetoPCombi,GamaCombi,E_inicialCombi,E_FinalesCombi)
  
  ConjuntoPizarra=copiararray(ConjuntoQ1,ConjuntoQ2)
  GamaPizarra=copiararray(Gama1,Gama2)
  graph()
}

function ResetearAutomata(estados,alfabeto,alfabetopila,gama,e_inicial,e_finales)
{
  estados=estados.splice(0,estados.length)
  alfabeto=alfabeto.splice(0,alfabeto.length)
  alfabetopila=alfabetopila.splice(0,alfabeto.length)
  gama=gama.splice(0,gama.length)
  e_inicial=null
  e_finales=e_finales.splice(0,e_finales.length)
  return e_inicial
}

function validar_estadosx(comparador,a_comparar)
{
  if(Array.isArray(a_comparar))
  {
    for(let i=0;i<a_comparar.length;i++)
    {
      if(!comparador.includes(a_comparar[i]))
        return false
    }
  }
  else
      if(!comparador.includes(a_comparar))
        return false
  return true
}
//                    conjuntoQ  Alfabeto  AlfabetoP Gama
function validar_gama(comparador1,comparador2,comparador3,a_comparar)
{
  for(let i=0;i<a_comparar.length;i++)
  {
    if(!comparador1.includes(a_comparar[i][0]))
      return false
    if(!(comparador2.includes(a_comparar[i][1])||a_comparar[i][1]=="@"))
      return false
    if(!(comparador3.includes(a_comparar[i][2])||a_comparar[i][2]=="@"))
        return false
    if(!(comparador3.includes(a_comparar[i][3])||a_comparar[i][3]=="@"))
        return false
    if(!comparador1.includes(a_comparar[i][4]))
      return false
  }
  return true
}

function limpiar()
{
  console.clear()
}

function mostrardatos(conjunto,alfabeto,alfabetopila,gama,e_ini,e_final,Nautomata)
{
    console.log("Estados "+Nautomata+":",conjunto)
    console.log("Alfabeto Pila "+Nautomata+":",alfabetopila)
    console.log("Alfabeto "+Nautomata+":",alfabeto)
    console.log("Transiciones "+Nautomata+":",gama)
    console.log("Estados finales "+Nautomata+":",e_final)
    console.log("Estado inicial "+Nautomata+":",e_ini)
}


function Union()
{
  limpiar()
  if(ConjuntoQ1.length>0 && ConjuntoQ2.length>0)
  {
    if(compararalfabeto(Alfabeto1,Alfabeto2))
    {
      mostrardatos(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1,"A1")
      mostrardatos(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2,"A2")

      var inicio1=ConjuntoQ1[0]
      var inicio2=ConjuntoQ2[0]

      E_inicialCombi="X"

      ConjuntoCombi=copiararray(ConjuntoQ1,ConjuntoQ2)
      ConjuntoCombi.splice(0,0,E_inicialCombi)

      GamaCombi=copiararray(Gama1,Gama2)
      
      GamaCombi.splice(0,0,añadirtransicion(E_inicialCombi,"@","@","@",inicio1))
      GamaCombi.splice(0,0,añadirtransicion(E_inicialCombi,"@","@","@",inicio2))

      GamaCombi=epsilon(GamaCombi)

      E_FinalesCombi=copiararray(E_Finales1,E_Finales2)

      ConjuntoPizarra=copiararray(ConjuntoCombi,[])
      GamaPizarra=copiararray(GamaCombi,[])

      mostrardatos(ConjuntoCombi,Alfabeto1,AlfabetoP1,GamaCombi,E_inicialCombi,E_FinalesCombi,"Au")
      graph()
    }
    else
      alert("Los automatas no tienen coincidencias en sus alfabetos")
  }
  else
    alert("Debe ingresar ambos automatas")
}

function epsilon(transiciones)
{
  for(let i=0;i<transiciones.length;i++)
  {
    if(transiciones[i][1].charCodeAt()==64)
        transiciones[i][1]=String.fromCharCode(36)
    if(transiciones[i][2].charCodeAt()==64)
        transiciones[i][2]=String.fromCharCode(36)
    if(transiciones[i][3].charCodeAt()==64)
        transiciones[i][3]=String.fromCharCode(36)
  }
  return transiciones
}


function Concatenar()
{
  limpiar()
  if(ConjuntoQ1.length>0 && ConjuntoQ2.length>0)
  {
    if(compararalfabeto(Alfabeto1,Alfabeto2))
    {
      var a1=document.getElementById("Conca1").value
      var a2=document.getElementById("Conca2").value
      if(a1.length>0 && a2.length>0)
      {
        if((a1=="1" || a1=="2") && (a2=="1" || a2=="2") && a1!=a2)
        {
          if(a1=="1")
          {

            mostrardatos(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1,"A1")
            mostrardatos(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2,"A2")

            ConjuntoQ1.splice(0,0,"Ni")
            ConjuntoQ1.push("Nf")

            ConjuntoCombi=Datos_dupli(copiararray(ConjuntoQ1,ConjuntoQ2))
            GamaCombi=copiararray(Gama1,Gama2)
            AlfabetoCombi=Datos_dupli(copiararray(Alfabeto1,Alfabeto2))
            AlfabetoPCombi=Datos_dupli(copiararray(AlfabetoP1,AlfabetoP2))
            E_FinalesCombi=copiararray(E_Finales1,E_Finales2)

            E_inicialCombi="Ni"

            GamaCombi.splice(0,0,añadirtransicion("Ni","@","@","P",E_inicial1))

            var copia_e_f=copiararray(E_Finales1,[])

            for(let i=0;i<copia_e_f.length;i++)
            {
              GamaCombi.splice(0,0,añadirtransicion(copia_e_f[i],"@","P","@","Nf"))
              copia_e_f.splice(i,1) 
              E_FinalesCombi.splice(i,1)
              i=-1
            }

            GamaCombi.push(añadirtransicion("Nf","@","@","@",E_inicial2))

            GamaCombi=epsilon(GamaCombi)

           
            ConjuntoPizarra=copiararray(ConjuntoCombi,[])
            GamaPizarra=copiararray(GamaCombi,[])
      
            mostrardatos(ConjuntoCombi,AlfabetoCombi,AlfabetoPCombi,GamaCombi,E_inicialCombi,E_FinalesCombi,"Ac")

            graph()
          }
          else
          {
            mostrardatos(ConjuntoQ2,Alfabeto2,AlfabetoP2,Gama2,E_inicial2,E_Finales2,"A2")
            mostrardatos(ConjuntoQ1,Alfabeto1,AlfabetoP1,Gama1,E_inicial1,E_Finales1,"A1")

            ConjuntoQ2.splice(0,0,"Ni")
            ConjuntoQ2.push("Nf")

            ConjuntoCombi=Datos_dupli(copiararray(ConjuntoQ2,ConjuntoQ1))
            GamaCombi=copiararray(Gama2,Gama1)
            AlfabetoCombi=Datos_dupli(copiararray(Alfabeto2,Alfabeto1))
            AlfabetoPCombi=Datos_dupli(copiararray(AlfabetoP2,AlfabetoP1))
            E_FinalesCombi=copiararray(E_Finales2,E_Finales1)

            E_inicialCombi="Ni"

            GamaCombi.splice(0,0,añadirtransicion("Ni","@","@","P",E_inicial2))

            var copia_e_f=copiararray(E_Finales2,[])

            for(let i=0;i<copia_e_f.length;i++)
            {
              GamaCombi.splice(0,0,añadirtransicion(copia_e_f[i],"@","P","@","Nf"))
              copia_e_f.splice(i,1) 
              E_FinalesCombi.splice(i,1)
              i=-1
            }

            GamaCombi.push(añadirtransicion("Nf","@","@","@",E_inicial1))

            GamaCombi=epsilon(GamaCombi)

            ConjuntoPizarra=copiararray(ConjuntoCombi,[])
            GamaPizarra=copiararray(GamaCombi,[])
        
            mostrardatos(ConjuntoCombi,AlfabetoCombi,AlfabetoPCombi,GamaCombi,E_inicialCombi,E_FinalesCombi,"Ac")

            graph()
          }
        }
        else
          alert("Los automatas ingresados no coinciden con [1,2] o ingreso el mismo automata dos veces")
      }
      else
        alert("No deben quedar en blanco los campos de concatenacion")
    }
    else
      alert("No comparten concordancias en sus alfabetos")
  }
  else
    alert("Debe ingresar ambos automatas")
}

function estados3deE(estado,gama)
{
  var resultado=[]
  resultado.push(estado)
  for(let i=0;i<gama.length;i++)
    if(estado==gama[i][0]&&gama[i][1]=="$")
    {
      resultado.push(gama[i][2])
      estado=gama[i][2]
    }
  return resultado
}

function tiene3(estado,gama)
{
  for(let i=0;i<gama.length;i++)
    if(estado==gama[i][0]&&gama[i][1]=="$")
      return true
  return false
}

function copia(gama)
{
  var resultado=[]
  for(let i=0;i<gama.length;i++)
  {
    var conex=[]
    for(let j=0;j<3;j++)
      conex.push(gama[i][j])
    resultado.push(conex)
  }
  return resultado
}

function estados3alfaconsumido(estado,gama)
{
  var respuesta=""
  var copiag=copia(gama)
  while(tiene3(estado,copiag))
  {
    var estados3=estados3deE(estado,copiag)

    for(let i=estados3.length-1;i>0;i--)
    {
      if(tiene3(estados3[i],copiag))
        respuesta+=estados3alfaconsumido(estados3[i],copiag) 
    	for(let j=0;j<copiag.length;j++)
      {
        if(estados3[i]==copiag[j][2] && copiag[j][1]=="$" && copiag[j][0]==estados3[i-1])
        {
          copiag.splice(j,1)
          j=0
          respuesta=respuesta +","+estados3[i]
        }
      }
     }
  }
  return respuesta
}

function estado3alfasinconsumir(estado,alfa,gama)
{
  var respuesta=""
  var copiag=copia(gama)
  while(tiene3(estado,copiag))
  {
    var estados3=estados3deE(estado,copiag)
    for(let i=estados3.length-1;i>0;i--)
    {
      if(tiene3(estados3[i],copiag))
        respuesta+=estado3alfasinconsumir(estados3[i],alfa,copiag)
      for(let j=0;j<copiag.length;j++)
      {
        if(estados3[i]==copiag[j][0] && copiag[j][1]==alfa)
          respuesta=respuesta + "," + copiag[j][2]
        if(estados3[i]==copiag[j][2] && copiag[j][1]=="$" && copiag[j][0]==estados3[i-1])
        {
            copiag.splice(j,1)
            j=0
        }
      }
    }
  }
  return respuesta
}

function añadirconex3(matriz,gama)
{
  for(let i=1;i<matriz.length;i++)
  {
    for(let j=1;j<matriz[0].length;j++)
    {
      var respuesta=""
      respuesta+=estados3alfaconsumido(matriz[i][j],gama)
      respuesta+=estado3alfasinconsumir(matriz[i][0],matriz[0][j],gama)
      if(matriz[i][j]!="-")
      {
        matriz[i][j]+=respuesta
        matriz[i][j]=artostr(Datos_dupli(matriz[i][j].split(",")))
      }
      else
      {
        if(respuesta!="")
        {
          matriz[i][j]=respuesta.substring(1,respuesta.length)
          matriz[i][j]=artostr(Datos_dupli(matriz[i][j].split(",")))
        }
      }
    }
  }
  return matriz
}

function copiararray(datos1,datos2)
{
  var resultado=[]
  for(let index=0;index<(datos1.length+datos2.length);index++)
  {
    if(index<datos1.length)
      resultado.push(datos1[index])
    else
      resultado.push(datos2[index-datos1.length])
  }
  return resultado
}

function cambiarcaracter(estados1,estados2)
{
  for(let i=0;i<estados1.length;i++)
  {
    if(estados2.includes(estados1[i]))
    {
      var indice=estados2.indexOf(estados1[i])
      var aux=estados2[indice]
      while(estados2.includes(aux) || estados1.includes(aux) )
      {
          if(aux[0].charCodeAt()==57 || aux[0].charCodeAt()==90 ||  aux[0].charCodeAt()==122){

          if(aux[0].charCodeAt()==57){
            aux=aux.replace(aux[0],String.fromCharCode(aux[0].charCodeAt()+8))
          }
          if(aux[0].charCodeAt()==90){
            aux=aux.replace(aux[0],String.fromCharCode(aux[0].charCodeAt()+7))
          }
          if(aux[0].charCodeAt()==122){
            aux=aux.replace(aux[0],String.fromCharCode(aux[0].charCodeAt()-74))
          }
         }
         else
              aux=aux.replace(aux[0],String.fromCharCode(aux[0].charCodeAt()+1)) 
      }
      estados2[indice]=aux
    }
  }
 return estados2
}

//               nuevas funciones
function ids(estados,conjunto)
{
	var ids=[]
  for(let i=0;i<conjunto.length;i++)
  {
  	if(conjunto.includes(estados[i]))
  		ids.push(conjunto.indexOf(estados[i]))
  }
  return ids
}
function e_finales(ids,conjunto)
{
	var e_finales=[]
	for(let i=0;i<ids.length;i++)
  	e_finales.push(conjunto[ids[i]])
  return e_finales
}
function ids_gama(gama,conjunto)
{
	var gamaN=[]
  for(let i=0;i<gama.length;i++)
  if(conjunto.includes(gama[i][0])&&conjunto.includes(gama[i][4]))
  	gamaN.push(añadirtransicion(conjunto.indexOf(gama[i][0]),gama[i][1],gama[i][2],gama[i][3],conjunto.indexOf(gama[i][4])))
  return gamaN
}
function gama(ids,conjunto)
{
	var gama_r=[]
  for(let i=0;i<ids.length;i++)
  	gama_r.push(añadirtransicion(conjunto[ids[i][0]],ids[i][1],ids[i][2],ids[i][3],conjunto[ids[i][4]]))
  return gama_r
}
//               nuevas funciones/>

function cambiarcaractergama(g1,g2)
{
  for(let i=0;i<g1.length;i++)
    for(let j=0;j<g2.length;j++)
    {
      if(g1[i][0]==g2[j][0])
        g2[j][0]=compararletra(g1[i][0],g2[j][0])
      if(g1[i][0]==g2[j][2])
        g2[j][2]=compararletra(g1[i][0],g2[j][2])
      if(g1[i][2]==g2[j][0])
        g2[j][0]=compararletra(g1[i][2],g2[j][0])
      if(g1[i][2]==g2[j][2])
        g2[j][2]=compararletra(g1[i][2],g2[j][2])
    } 
  return g2
}

function compararletra(palabra1,palabra2)
{
  if(palabra1.length>0 && palabra2.length>0)
  {
	if(caractervalido(palabra1[0]) && caractervalido(palabra2[0]))
  {
  	if(palabra1==palabra2)
    {
    	if(palabra2[0].charCodeAt()==57 || palabra2[0].charCodeAt()==90 || palabra2[0].charCodeAt()==122){
      	
        if(palabra2[0].charCodeAt()==57){
          palabra2=palabra2.replace(palabra2[0],String.fromCharCode(palabra2[0].charCodeAt()+8))
        }
        if(palabra2[0].charCodeAt()==90){
          palabra2=palabra2.replace(palabra2[0],String.fromCharCode(palabra2[0].charCodeAt()+7))
        }
        if(palabra2[0].charCodeAt()==122){
          palabra2=palabra2.replace(palabra2[0],String.fromCharCode(palabra2[0].charCodeAt()-74))
        }
      }
      else
      	palabra2=palabra2.replace(palabra2[0],String.fromCharCode(palabra2[0].charCodeAt()+1))
    }
    return palabra2
  }
  }
  
}

function caractervalido(palabra)
{
	for(let i=0;i<palabra.length;i++)
  {
  	if(palabra[i].charCodeAt()<48 || (palabra[i].charCodeAt()>57 && palabra[i].charCodeAt()<65) || (palabra[i].charCodeAt()>90 && palabra[i].charCodeAt()<97) || palabra[i].charCodeAt()>122)
    	return false
  }
  return true
}


//Funciones de creacion y visualizacion de automatas

function visestado(arreglo)
{
  var object=[]
  for(let index=0;index<arreglo.length;index++)
  {
    const element=arreglo[index]
    object.push({id: index+1, label: element})
  }
  return object
}

function alfabetoxestado(arreglo)
{
  var object=[]
  arreglo.forEach(element => {object.push({from: Buscar_id(ConjuntoPizarra,element[0]), to: Buscar_id(ConjuntoPizarra,element[4]), label: element[1]+"/"+element[2]+"/"+element[3]})})
  return object
}

function Buscar_id(arreglo, nombre)
{
  for(let index=0;index<arreglo.length;index++)
  {
    if(nombre==arreglo[index])
      return index+1
  }
    
}

function Datos_dupli(arreglo)
{
  for(let index=0;index<arreglo.length;index++)
    for(let jdex=0;jdex<arreglo.length;jdex++)
    {
      if(index!=jdex)
      {
        if(arreglo[index]==arreglo[jdex])
          arreglo.splice(jdex,1)
      }
    }
  return arreglo
}


function Comparar(arr1,arr2)
{
  for(let z=0;z<arr1.length;z++)
  {
    if(arr1[z]==arr2[z])
      return true
  }
  return false
}

function graph()
{
    node=new vis.DataSet(visestado(ConjuntoPizarra))
    edge=new vis.DataSet(alfabetoxestado(GamaPizarra))
    container= document.getElementById('mynetwork')
    data={nodes: node, edges: edge}
    options={edges:{arrows:{to:{enabled:true}}}}
    network= new vis.Network(container, data, options)

}
 
 //Fin funciones visualizacion y creacion de automata


    

// Funciones para simplificar afd

function final_nofinal(id,estadosf)
{
  if(estadosf.includes(id))  // true = final
    return true
  else                      //false = nofinal
    return false
}


function CompararArray(arr1,arr2)
{
  for(let i=0;i<arr1.length;i++)
  {
    if(!arr2.includes(arr1[i]))
      return false
  }
  return true
}

function añadirtransicion(estado_e,alfa,alfap1,alfap2,estado_s)
{
  var conex=[]
  conex.push(estado_e)
  conex.push(alfa)
  conex.push(alfap1)
  conex.push(alfap2)
  conex.push(estado_s)
  return conex
}

function artostr(arreglo)
{
  var r=""
  for(let i=0;i<arreglo.length;i++)
  {
    if(i>0)
      r=r+","+arreglo[i]
    else
      r+=arreglo[i]
  }
  return r
}
function compararalfabeto(arr1,arr2)
{
  if(comparararreglo(arr1,arr2) && comparararreglo(arr2,arr1))
    return true
  else
    return false
}
function comparararreglo(arr1,arr2)
{
  for(let i=0;i<arr1.length;i++)
  {
    if(!existealfa(arr1[i],arr2))
      return false
  }
  return true
}

function existealfa(string,arreglo)
{
  var strr=string.split("")
  for(let i=0;i<strr.length;i++)
    if(!arreglo.includes(strr[i]))
      return false
  return true
}

function strgama(gama)
{
    var str="y las transiciones son: \n"
  for(let i=0;i<gama.length;i++)
      str=str+gama[i][0]+" - "+gama[i][1]+"/"+gama[i][2]+"/"+gama[i][3]+" - "+gama[i][4]+"\n"
     return str
}

function strestados(estados)
{
  var str="Los estados son: \n"
  for(let i=0;i<estados.length;i++){
    if(i!=estados.length - 1){
       str=str+estados[i]+" - "
    }
    else
      str=str+estados[i]+" \n"
  }

  return str
}

</script>
