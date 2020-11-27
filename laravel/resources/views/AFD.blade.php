<html>
<head>
    <!-- <script type="text/javascript" src="vis/disc">
    
    </script> -->
</head>
<body>
            
</body>
</html> 
<!doctype html>
<html>
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
        
</script>
<div id="mynetwork"></div>

<!-- <form method="post" action="#"> -->

<!-- Ingreso de datos automata n°1 visual -->
<table border="0">  
<caption>Datos Automatas</caption>
<tr>
<td width="25%">Conjunto de estados Q:</td>
<td width="70%"><input type="text" name="conjuntoQ" placeholder="q1,q2,q3,...,qn" id="Q" > Formato: estado1,estado2,estado3, </td>
</tr>
<tr>
<td width="25%">Alfabeto:</td>
<td width="70%"><input type="text" name="Alfabeto" placeholder="a,b,c,d,..." id="Alfabeto" > Formato: letra/num, </td>
</tr>
<tr>
<td width="25%">Estado inicial:</td>
<td width="70%"><input type="text" name="Inicial" placeholder="q" id="Inicial" > Formato: estado, </td>
</tr>
<tr>
<td width="25%">Función de transición:</td>
<td width="70%"><input type="text" name="Gama" placeholder="q,a,q;" id="Gama" > Formato: estadoentrada,alfabeto,estadosalida; </td>
<tr>
<td width="25%">Estado(s) final(es):</td>
<td width="70%"><input type="text" name="Finales" placeholder="q1,q2,q3,q4,..." id="Finales" > Formato: estado,estado </td><br>
</tr>
</table>
<button onclick="ValidarEntrada1()">Ingresar automata </button>
<button onclick="AFD_ER()">Transformar a ER </button>
<button onclick="reset()">Reset </button>



<!-- Fin entrada de datos automata n°1 -->


<script type="text/javascript">

var E_inicial1="",E_inicial2,E_inicialP

var ConjuntoQ1=[],ConjuntoP=[]

var Alfabeto1=[]

var Gama1=[],GamaP=[]

var E_Finales1=[],E_FinalesP=[]

var node,edge,data,container,options,network


function ValidarEntrada1()
{
    limpiar()

    if(ConjuntoQ1.length>0)
      E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,Gama1,E_inicial1,E_Finales1)

    E_inicial1=document.getElementById("Inicial").value
    var Q=document.getElementById("Q").value
    var A=document.getElementById("Alfabeto").value
    var G=document.getElementById("Gama").value
    var F=document.getElementById("Finales").value

    let valQ=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valA=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valF=/^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g
    let valG=/^[a-zA-Z0-9]+,(@|[a-zA-Z0-9]+),[a-zA-Z0-9]+(;[a-zA-Z0-9]+,(@|[a-zA-Z0-9]+),[a-zA-Z0-9]+)*$/g

    if(Q.length == 0 || A.length == 0 || G.length == 0 || E_inicial1.length == 0 || F.length == 0)
        alert("Hay campos en blanco")
    else
    {
        if(valQ.test(Q) && valA.test(A) && valG.test(G) && valF.test(F) && caractervalido(E_inicial1))
        {
          Alfabeto1=Datos_dupli(A.split(','))
          ConjuntoQ1=Datos_dupli(Q.split(','))
          E_Finales1=Datos_dupli(F.split(','))
          Gama1=_Gama(Datos_dupli(G.split(';')))

          if(ContieneEstado(E_inicial1,ConjuntoQ1) && ContieneEstado(E_Finales1,ConjuntoQ1) && validar_gama(ConjuntoQ1,Alfabeto1,Gama1))
          {
            ConjuntoQ1.splice(0,0,E_inicial1)
            ConjuntoQ1=Datos_dupli(ConjuntoQ1)
            
            Gama1=epsilon(Gama1)  

            mostrardatos(ConjuntoQ1,Alfabeto1,Gama1,E_inicial1,E_Finales1,"A1")

            E_inicialP=E_inicial1
            ConjuntoP=Pizarra(ConjuntoQ1)
            GamaP=Pizarra(Gama1)
            E_FinalesP=Pizarra(E_Finales1)

            graph()
          }
          else
          {
            alert("Datos no validos")
          }
        }
        else
          alert("Formato ingresado no valido") 
    }
}

function AFD_ER()
{
  Afd_to_Er(ConjuntoQ1,Alfabeto1,Gama1,E_Finales1,E_inicial1)
}

function reset()
{
  limpiar()
  console.log("Datos borrados.")
  E_inicial1=ResetearAutomata(ConjuntoQ1,Alfabeto1,Gama1,E_inicial1,E_Finales1)
  console.log(ConjuntoQ1,Alfabeto1,Gama1,E_inicial1,E_Finales1)
  E_inicial2=ResetearAutomata(ConjuntoQ2,Alfabeto2,Gama2,E_inicial2,E_Finales2)
  console.log(ConjuntoQ2,Alfabeto2,Gama2,E_inicial2,E_Finales2)
  E_inicial3=ResetearAutomata(ConjuntoQ3,Alfabeto3,Gama3,E_inicial3,E_Finales3)
  console.log(ConjuntoQ3,Alfabeto3,Gama3,E_inicial3,E_Finales3)
  E_inicialCombi=ResetearAutomata(ConjuntoCombi,[],GamaCombi,E_inicialCombi,E_FinalesCombi)
  console.log(ConjuntoCombi,[],GamaCombi,E_inicialCombi,E_FinalesCombi)
  graph()
}

function ResetearAutomata(estados,alfabeto,gama,e_inicial,e_finales)
{
  estados=estados.splice(0,estados.length)
  alfabeto=alfabeto.splice(0,alfabeto.length)
  gama=gama.splice(0,gama.length)
  e_inicial=null
  e_finales=e_finales.splice(0,e_finales.length)
  return e_inicial
}

function ContieneEstado(estados, contenedor)
{
  if(!Array.isArray(estados)) 
  {
    if(contenedor.includes(estados))
      return true
    else
      return false
  }
  else
  {
    for(let i=0;i<estados.length;i++)
      if(!contenedor.includes(estados[i]))
        return false
    return true
  }

}

function validar_gama(comparador1,comparador2,a_comparar)
{
  for(let i=0;i<a_comparar.length;i++)
  {
    if(!comparador1.includes(a_comparar[i][0]))
      return false
    if(!(comparador2.includes(a_comparar[i][1])||a_comparar[i][1]=="$"))
      return false
    if(!comparador1.includes(a_comparar[i][2]))
      return false
  }
  return true
}

function caractervalido(estado)
{
  var Er=/[A-Za-z0-9]*/g
  if(Er.test(estado))
    return true
  return false
}

function limpiar()
{
  console.clear()
}

function mostrardatos(conjunto,alfabeto,gama,e_ini,e_final,Nautomata)
{
    console.log("Estados "+Nautomata+":",conjunto)
    console.log("Alfabeto "+Nautomata+":",alfabeto)
    console.log("Transiciones "+Nautomata+":",gama)
    console.log("Estados finales "+Nautomata+":",e_final)
    console.log("Estado inicial "+Nautomata+":",e_ini)

    console.log("Tabla de estados "+Nautomata+":",añadirconex3(tabla_estados(conjunto,alfabeto,gama),gama)) 
}

function Pizarra(contenido)
{
  var pizarra=[]
  for(let i=0;i<contenido.length;i++)
    pizarra.push(contenido[i])
  return pizarra
}

function epsilon(transiciones)
{
  for(let i=0;i<transiciones.length;i++)
    if(transiciones[i][1].charCodeAt()==64)
      transiciones[i][1]=String.fromCharCode(36)
  return transiciones
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

function optimizar(estados1,estados2,alfa,gama1,gama2,estadosf)
{
  var matriz_d=matriz_distinguible(tabla_estados(estados1,alfa,gama1),estados1,alfa,estadosf)
  if(equivalencias(matriz_d))
  {
    while(equivalencias(matriz_d))
    {
      var id_d=buscar_disti(matriz_d)
      console.log("Matriz distinguible: ",matriz_distinguible(tabla_estados(estados1,alfa,gama1),estados1,alfa,estadosf))
      console.log("Estados: ",estados1)
      console.log("Alfabeto: ",alfa)
      console.log("Transiciones: ",gama1)
      for(let index=0;index<gama1.length;index++)
      {
        if(gama1[index][0]==estados1[Buscar_id(estados1,id_d[1])-1])
        {
          gama1.splice(index,1)
          index=0
        }
        if(gama1[index][2]==estados1[Buscar_id(estados1,id_d[1])-1])
        {
          var aux=[]
          aux.push(gama1[index][0])
          aux.push(gama1[index][1])
          aux.push(estados1[Buscar_id(estados1,id_d[0])-1])

          gama1.splice(index,1,aux)
          index=0
        }
      }
    estados1.splice(Buscar_id(estados1,id_d[1])-1,1)
    console.log("Matriz distinguible: ",matriz_distinguible(tabla_estados(estados1,alfa,gama1),estados1,alfa,estadosf))
    console.log("Estados: ",estados1)
    console.log("Alfabeto: ",alfa)
    console.log("Transiciones: ",gama1)
      
    ConjuntoQ3=copiararray(estados1,estados2)
    Gama3=copiararray(gama1,gama2)

    }
    graph()
  }
  else
    alert("El automata ya se encuentra en su estado minimo")

  
  

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
  arreglo.forEach(element => {object.push({from: Buscar_id(ConjuntoP,element[0]), to: Buscar_id(ConjuntoP,element[2]), label: element[1]})})
  return object
}

function _Gama(arreglo)
{
  var gama=[]
  for(let index=0;index<arreglo.length;index++)
    gama.push(arreglo[index].split(','))
  return gama
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

function gama_dupli(arreglo)
{
  for(let index=0;index<arreglo.length;index++)
	  for(let jdex=0;jdex<arreglo.length;jdex++)
	  {
      if(index!=jdex)
      {
        if(Comparar(arreglo[index],arreglo[jdex]))
        {  
          arreglo.splice(jdex,1)
          jdex=0
        }
      }
	  }
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
    node=new vis.DataSet(visestado(ConjuntoP))
    edge=new vis.DataSet(alfabetoxestado(GamaP))
    container= document.getElementById('mynetwork')
    data={nodes: node, edges: edge}
    options={edges:{arrows:{to:{enabled:true}}}}
    network= new vis.Network(container, data, options)

}
 
 //Fin funciones visualizacion y creacion de automata

function tabla_estados(estados,alfabeto,Ftrans)
{
  var matriz=[]
  for(let index=0;index<=estados.length;index++)
  {
    var columnas=[]
    for(let jdex=0;jdex<=alfabeto.length;jdex++)
    {
      if(index == 0 && jdex == 0)
        columnas.push('n')
      else
      {
        if(index == 0)
          columnas.push(alfabeto[jdex-1])
        if(jdex == 0)
          columnas.push(estados[index-1])
      }
      if(index != 0 && jdex != 0)
        { 
          var paso=0
          for(let i=0;i<Ftrans.length;i++)
          {  
            if(Ftrans[i][0] == columnas[0] && Ftrans[i][1] == matriz[0][jdex])
            {
              if(columnas[jdex]==null)
                columnas.push(Ftrans[i][2])
              else
                columnas[jdex]=columnas[jdex]+","+Ftrans[i][2]
              paso=1
            }
          }
          if(paso==0)
            columnas.push("-")
        }
    }
    matriz.push(columnas)
  }
  return matriz
}
    

// Funciones para simplificar afd

/* function Compatibles() */

function factorial(numero)
{
  var resultado=1
  while(numero>0)
  {
    resultado*=numero
    numero--
  }
  return resultado
}

function coef_binomial(numero)
{
  var resultado=factorial(numero)/(factorial(2)*factorial(numero-2))
  return resultado
}

function matrizvacia(arreglo)
{
  var matriz=[]
  for(let index=0;index<=arreglo.length;index++)
  {
    var columnas=[]
    for(let jdex=0;jdex<=arreglo.length;jdex++)
    {
      if(index == 0 && jdex == 0)
        columnas.push('n')
      else
      {
        if(index == 0)
          columnas.push(arreglo[jdex-1])
        if(jdex == 0)
          columnas.push(arreglo[index-1])
         
      }
      if(index != 0 && jdex != 0)
      { 
        if(index==jdex)
          columnas.push(-1)
        else
          columnas.push(0)
      }
    }
    matriz.push(columnas)
  }
  return matriz
}

function matriz_distinguible(matriz,estados,alfa,estados_f)
{
  var matriz_resultado=matrizvacia(estados)
  var id_i=1,id_f=estados.length,iteracion=0

  while(iteracion<coef_binomial(estados.length))
  {
    while(id_i!=id_f)
    {
      if(final_nofinal(matriz[id_i][0],estados_f)!=final_nofinal(matriz[id_f][0],estados_f))
      {
        matriz_resultado[id_i][id_f]=1
        matriz_resultado[id_f][id_i]=1
      } 
      else
      {
        var aux=1
        while(aux<=alfa.length)
        {
          if(final_nofinal(matriz[id_i][aux],estados_f)!=final_nofinal(matriz[id_f][aux],estados_f))
          {
            matriz_resultado[id_i][id_f]=1
            matriz_resultado[id_f][id_i]=1
            aux=alfa.length
          }
          aux++
        }
      }
      id_f--
      iteracion++
    }
    id_i++
    id_f=estados.length
  }
  return matriz_resultado
}

function afnd_to_afd(matriz,estado_i,estado_f,conjuntoq,alfabeto,gama)
{
  estado_i+=estados3alfaconsumido(estado_i,gama)
  var nuevoQ=[]
  var nuevoG=[]
  var nuevoF=[]
  nuevoQ.push(estado_i)
  for(let i=0;i<nuevoQ.length;i++)
  {  
    for(let j=0;j<alfabeto.length;j++)
    {
      if(nuevoQ[i]!="S")
      {
        var estadoU=""
        var estadoaux=nuevoQ[i].split(",")
        /* console.log(estadoaux) */
        for(let k=0;k<estadoaux.length;k++)
        {
          if(Cdirige(matriz,estadoaux[k],alfabeto[j])!="-")
          {
            if(estadoU!="")
              estadoU=estadoU+","+Cdirige(matriz,estadoaux[k],alfabeto[j])
            else
              estadoU+=Cdirige(matriz,estadoaux[k],alfabeto[j])
            /* console.log(Cdirige(matriz,estadoaux[k],alfabeto[j])) */
          }
        }
        if(estadoU!="")
        {
          estadoU=artostr(Datos_dupli(estadoU.split(",")))
          nuevoG.push(añadirtransicion(nuevoQ[i],alfabeto[j],estadoU))
          if(noexiste(estadoU,nuevoQ))
            nuevoQ.push(estadoU)
          if(existefinal(estadoU,estado_f))
            nuevoF.push(estadoU)
        }
        else
        {
          estadoU="S"
          nuevoG.push(añadirtransicion(nuevoQ[i],alfabeto[j],estadoU))
          if(noexiste(estadoU,nuevoQ))
            nuevoQ.push(estadoU)
        }
      }
      else
        nuevoG.push(añadirtransicion(nuevoQ[i],alfabeto[j],nuevoQ[i])) 
    }
  }
  if(existefinal(nuevoQ[0],estado_f))
    nuevoF.push(nuevoQ[0])
  var respuesta=[]
  nuevoF=Datos_dupli(nuevoF)
  respuesta.push(estado_i)
  respuesta.push(nuevoQ)
  respuesta.push(alfabeto)
  respuesta.push(nuevoG)
  respuesta.push(nuevoF)
  
  return respuesta
}

function final_nofinal(id,estadosf)
{
  if(estadosf.includes(id))  // true = final
    return true
  else                      //false = nofinal
    return false
}

function buscar_disti(matriz)
{
  var ids=[]
  for(let index=1;index<matriz.length;index++)
    for(let jdex=1;jdex<matriz.length;jdex++)
      if(matriz[index][jdex]==0)
      {
        matriz[index][jdex]=1
        matriz[jdex][index]=1
        ids.push(matriz[0][index])
        ids.push(matriz[jdex][0])
        return ids
      }
}

function equivalencias(matriz)
{
  var ids=[]
  for(let index=1;index<matriz.length;index++)
    for(let jdex=1;jdex<matriz.length;jdex++)
      if(matriz[index][jdex]==0)
        return true
  return false
}

function EsAFD(estados,alfabeto,gama)
{
  for(let i=0;i<estados.length;i++)
  {
    var cont=0
    for(let j=0;j<gama.length;j++)
    {
      if(estados[i]==gama[j][0])
      {
        if(transicion_repetida(gama[j],gama,j))
          cont++
      }
      if(gama[j][1]=="$")
        return false
    }
    if(cont!=alfabeto.length)
      return false
  }
  return true
}

function transicion_repetida(transicion,gama,posicion)
{
  for(let i=0;i<gama.length;i++)
  {
    if(i!=posicion)
    {
      if(transicion[0]==gama[i][0] && transicion[1]==gama[i][1] && transicion[2]==gama[i][2])
        return false
    }
  }
  return true
}


function añadirtransicion(estado_e,alfa,estado_s)
{
  var conex=[]
  conex.push(estado_e)
  conex.push(alfa)
  conex.push(estado_s)
  return conex
}

function Cdirige(matriz,estado,alfa)
{
  for(let i=1;i<matriz.length;i++)
    for(let j=1;j<matriz[0].length;j++)
      if(matriz[i][0]==estado && matriz[0][j]==alfa)
        return matriz[i][j]
}

function soniguales(string1,string2)
{
  var str1=string1.split(",")
  var str2=string2.split(",")

  if(str1.length!=str2.length)
    return false
  for(let i=0;i<str1.length;i++)
    if(!str2.includes(str1[i]))
      return false
  return true
}

function existefinal(string,arreglo)
{
  var strr=string.split(",")
  for(let i=0;i<strr.length;i++)
    if(arreglo.includes(strr[i]))
      return true
  return false
}

function noexiste(estado,conjunto)
{
  var bitc=0
  for(let i=0;i<conjunto.length;i++)
    if(soniguales(conjunto[i],estado))
      bitc=1
  if(bitc==1)
    return false
  else
    return true
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
//Funciones para obetener ER de un AFD
function Afd_to_Er(estados,alfabeto,gama,e_finales,e_inicial)
{
  if(TieneEntradas(e_inicial,gama))
    e_inicial=NuevoInicial(estados,gama,e_inicial)
  if(TieneSalidas(e_finales,gama))
    e_finales=NuevoFinal(estados,gama,e_finales)


  while(TieneSalidas(e_inicial,gama) && existeintermedio(estados,gama))
  {
    var eliminar=Terna_estados(e_inicial,gama)
    var estados_s=Salidas_de_x(eliminar[1],gama)
    var estados_e=Entradas_de_x(eliminar[1],gama)
    console.log(eliminar,estados_e,estados_s)
    for(let i=0;i<estados_e.length;i++)
    {
      for(let j=0;j<estados_s.length;j++)
      {
        console.log(estados_e[i],estados_s[j])
        mostrargama(gama)
        var resultante=simplificarexpresion(Uniones(estados_e[i],gama,eliminar[1]))
        console.log(resultante)
        resultante+=simplificarexpresion(Clausuras(eliminar[1],gama))
        console.log(resultante)
        resultante+=simplificarexpresion(Uniones(eliminar[1],gama,estados_s[j]))
        console.log(resultante)
        gama.push(añadirtransicion(estados_e[i],resultante,estados_s[j]))
        console.log(añadirtransicion(estados_e[i],resultante,estados_s[j]))
      }
    }
    var er=Uniones(eliminar[0],gama,eliminar[2])
    gama=EliminarT_de_x_y(eliminar[0],eliminar[2],gama)
    gama.push(añadirtransicion(eliminar[0],er,eliminar[2]))

    gama=EliminarTransiciones_de_x(eliminar[1],gama)
    //gama=EliminarT_de_x_y(eliminar[0],eliminar[1],gama)
    //gama=EliminarTransicionEspecifica(eliminar[0],ObtenerAlfa(eliminar[0],gama,eliminar[1]),eliminar[1],gama)
    console.log(gama)
    estados=EliminarEstado_x(eliminar[1],estados)
    console.log(estados)
  }

  mostrardatos(estados,alfabeto,gama,e_inicial,e_finales,"ER")
  ConjuntoP=Pizarra(estados)
  GamaP=Pizarra(gama)
  graph()
  alert("La expresión regular es: "+MostrarER(e_inicial,gama,e_finales))

}

function MostrarER(estado1,gama,estado2)
{
  for(let i=0;i<gama.length;i++)
    if(gama[i][0]==estado1 && gama[i][2]==estado2)
      return gama[i][1]
}

function mostrargama(gama)
{
  for(let i=0;i<gama.length;i++)
    console.log(gama[i])
}

function Entradas_de_x(estado,gama)
{
  var Conexiones=[]
  for(let i=0;i<gama.length;i++)
  {
    if(estado!==gama[i][0])
    {
      if(estado===gama[i][2])
      {
        if(!Conexiones.includes(gama[i][0]))
          Conexiones.push(gama[i][0])
      }
    }
  }
  return Conexiones
}

function Salidas_de_x(estado,gama)
{
  var Conexiones=[]
  for(let i=0;i<gama.length;i++)
  {
    if(estado==gama[i][0] && estado!=gama[i][2] &&!Conexiones.includes(gama[i][2]))
      Conexiones.push(gama[i][2])
  }
  return Conexiones
}

function EliminarT_de_x_y(estado1,estado2,gama)
{
  for(let i=0;i<gama.length;i++)
  {
    if(estado1==gama[i][0] && estado2==gama[i][2])
    {
      gama.splice(i,1)
      i=-1
    }
  }
  return gama
}

function EliminarTransicionEspecifica(estado1,alfa,estado2,gama)
{
  for(let i=0;i<gama.length;i++)
  {  
    if(estado1==gama[i][0]&&alfa==gama[i][1]&&estado2==gama[i][2])
    {  
      gama.splice(i,1)
      i=0
    }
  }
  return gama
}

function EliminarTransiciones_de_x(estado,gama)
{
  for(let i=0;i<gama.length;i++)
  {
    if(gama[i][0]==estado || gama[i][2]==estado)
    {
      gama.splice(i,1)
      i=-1
    }
  }
  return gama
}

function EliminarEstado_x(estado,conjunto)
{
  conjunto.splice(conjunto.indexOf(estado),1)
  return conjunto
}

function Clausuras(estado,gama)
{
  var str=""
  for(let i=0;i<gama.length;i++)
  {
    if(estado==gama[i][0] && estado==gama[i][2])
    {
      if(str!="")
        str=str+"+"+gama[i][1]
      else
        str=str+"("+gama[i][1]
    }
  }
  if(str!="")
    str+=")*"
  return str
}


function Uniones(estado1,gama,estado2)
{
  var str=""
  var bit_parentesis=0
  for(let i=0;i<gama.length;i++)
  {
    if(estado1==gama[i][0] && estado2==gama[i][2])
    {
      if(str!="")
        str=str+"+"+gama[i][1]
      else
      {
        if(gama[i][1][0]=="(")
        {
          str=str+gama[i][1]
          bit_parentesis=1
        }
        else
          str=str+"("+gama[i][1]
      }
    }
  }
  if(str.length>2)
  {
    if(bit_parentesis==0)
      str+=")"
  }
  else
    str=str.substring(1,str.length)
  return str
}

function simplificarexpresion(expresion)
{
  var er=expresion.split("")
  var erstr
  for(let i=0;i<er.length;i++)
  {
    if(er[i]=="$")
    {
      er.splice(i,1)
      i=-1
      erstr=ar_to_str(er)
    }
  }
  if(erstr!=null)
    return erstr
  return expresion
}
function ar_to_str(arr)
{
  var resp=""
  for(let i=0;i<arr.length;i++)
    resp+=arr[i]
  return resp
}

function ObtenerAlfa(estado1,gama,estado2)
{
  for(let i=0;i<gama.length;i++)
    if(gama[i][0]==estado1 && estado2==gama[i][2])
      return gama[i][1]
}

function NuevoFinal(estados,gama,e_fin)
{
  estados.push("Nf")
  for(let i=0;i<e_fin.length;i++)
    gama.push(añadirtransicion(e_fin[i],"$","Nf"))
  e_fin.splice(0,e_fin.length,"Nf")

  return e_fin
}

function NuevoInicial(estados,gama,e_ini)
{
  estados.splice(0,0,"Ni")
  gama.push(añadirtransicion("Ni","$",e_ini))
  return "Ni"
}

function TieneEntradas(estado,gama)
{
  for(let i=0;i<gama.length;i++)
    if(estado==gama[i][2])
      return true
  return false
}

function TieneSalidas(estados,gama)
{
  if(Array.isArray(estados))
  {
    for(let i=0;i<estados.length;i++)
      for(let j=0;j<gama.length;j++)
        if(estados[i]==gama[j][0])
          return true
    return false
  }
  else
  {
    for(let j=0;j<gama.length;j++)
        if(estados==gama[j][0])
          return true
    return false
  }
}

function Terna_estados(estado,gama)
{
  var estados=[]
  estados.push(estado)
	var segundoestado=0
  for(let i=0;i<gama.length;i++)
  {
      if(gama[i][0]==estado)
      {
        if(!estados.includes(gama[i][2]))
        { 
        	if(segundoestado==0)
          {
          	if(TieneSalidas(gama[i][2],gama))
            {  
              estado=gama[i][2]
              estados.push(estado)
              i=-1
              segundoestado=1
            }
          }
          else
          {
            estado=gama[i][2]
            estados.push(estado)
            if(estados.length==3)
              return estados
          }
         
        }
      }
  }

}

function existeintermedio(estados,gama)
{
	for(let i=0;i<estados.length;i++)
  {
  	if(Salidas_de_x(estados[i],gama).length>0)
    {
    	var salidas=Salidas_de_x(estados[i],gama)
      
      for(let j=0;j<salidas.length;j++)
      {
      	if(Salidas_de_x(salidas[j],gama).length>0)
        	return true
      }
    }
  }
  return false
}

</script>
</body>
</html>