<template>
  <div>
    <Grafo :key="recargarGrafo" :grafo="grafo" />
    <h1 class="title">Datos autómata</h1>
    <v-container fluid>
      <v-row>
        <v-col cols="2">
          <v-subheader>Conjunto de estados Q</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="conjuntoQ"
            outlined
            dense
            placeholder="q1,q2,q3,...,qn"
            v-model="Nodos"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: estado1,estado2,estado3,</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Alfabeto</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="Alfabeto"
            outlined
            dense
            placeholder="a,b,c,d,..."
            v-model="Alfabeto"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: letra/num,</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Estado inicial</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="Inicial"
            outlined
            dense
            placeholder="q"
            v-model="Inicial"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: estado,</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Función de transición</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="Gama"
            outlined
            dense
            placeholder="q,a,q;"
            v-model="GamaF"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader
            >Formato: estadoentrada,alfabeto,estadosalida;</v-subheader
          >
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Estado(s) final(es)</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="Finales"
            outlined
            dense
            placeholder="q1,q2,q3,q4,..."
            v-model="Finales"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: estado,estado</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" style="display: flex; justify-content: center">
          <v-btn color="secondary" depressed raised @click="this.ValidarEntrada1"
            >Ingresar autómata</v-btn
          >
          <v-btn color="primary" depressed raised @click="this.AFD_ER"
            >Transformar a ER</v-btn
          >
          <v-btn color="primary" depressed outlined raised @click="this.reset"
            >Limpiar</v-btn
          >
        </v-col>
      </v-row>
    </v-container>

    <!-- Fin entrada de datos automata n°1 -->
  </div>
</template>

<script>
import Grafo from "../components/Grafo.vue";

export default {
  name: "AFD",
  components: { Grafo },
  data() {
    return {
      grafo: {},
      Nodos: null,
      Alfabeto: null,
      Inicial: null,
      GamaF: null,
      Finales: null,
      recargarGrafo: false,
      E_inicial1: "",
      E_inicial2: null,
      E_inicialP: null,
      ConjuntoQ1: [],
      ConjuntoP: [],
      Alfabeto1: [],
      Gama1: [],
      GamaP: [],
      E_Finales1: [],
      E_FinalesP: [],
      node: null,
      edge: null,
      data: null,
      container: null,
      options: null,
      network: null,
    };
  },
  mounted() {},
  methods: {
    parsearGrafo() {
      if (this.ConjuntoP && this.GamaP != null) {
        var aristas = [];
        var letras = this.Alfabeto.split(",");
        var nodosF = this.Finales.split(",");
        for (var i = 0; i < this.GamaP.length; i++) {
          var arista = this.GamaP[i];
          aristas.push({
            origen: arista[0],
            destino: arista[2],
            alfabeto: arista[1],
          });
        }
        this.grafo = {
          nodos: this.ConjuntoP,
          alfabeto: letras,
          inicial: this.Inicial,
          aristas: aristas,
          finales: nodosF,
        };
        console.log("grafo", this.grafo);
        this.recargarGrafo = !this.recargarGrafo;
      }
    },
    ValidarEntrada1() {
      this.limpiar();
      if (this.ConjuntoQ1.length > 0) {
        this.E_inicial1 = this.ResetearAutomata(
          this.ConjuntoQ1,
          this.Alfabeto1,
          this.Gama1,
          this.E_inicial1,
          this.E_Finales1
        );
      }

      this.E_inicial1 = this.Inicial;
      var Q = this.Nodos;
      var A = this.Alfabeto;
      var G = this.GamaF;
      var F = this.Finales;

      let valQ = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valA = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valF = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valG = /^[a-zA-Z0-9]+,(@|[a-zA-Z0-9]+),[a-zA-Z0-9]+(;[a-zA-Z0-9]+,(@|[a-zA-Z0-9]+),[a-zA-Z0-9]+)*$/g;

      if (
        Q == null ||
        A == null ||
        G == null ||
        this.E_inicial1 == null ||
        F == null
      )
        alert("Hay campos en blanco");
      else {
        if (
          valQ.test(Q) &&
          valA.test(A) &&
          valG.test(G) &&
          valF.test(F) &&
          this.caractervalido(this.E_inicial1)
        ) {
          this.Alfabeto1 = this.Datos_dupli(A.split(","));
          this.ConjuntoQ1 = this.Datos_dupli(Q.split(","));
          this.E_Finales1 = this.Datos_dupli(F.split(","));
          this.Gama1 = this._Gama(this.Datos_dupli(G.split(";")));

          if (
            this.ContieneEstado(this.E_inicial1, this.ConjuntoQ1) &&
            this.ContieneEstado(this.E_Finales1, this.ConjuntoQ1) &&
            this.validar_gama(this.ConjuntoQ1, this.Alfabeto1, this.Gama1)
          ) {
            this.ConjuntoQ1.splice(0, 0, this.E_inicial1);
            this.ConjuntoQ1 = this.Datos_dupli(this.ConjuntoQ1);

            this.Gama1 = this.epsilon(this.Gama1);

            this.mostrardatos(
              this.ConjuntoQ1,
              this.Alfabeto1,
              this.Gama1,
              this.E_inicial1,
              this.E_Finales1,
              "A1"
            );

            this.E_inicialP = this.E_inicial1;
            this.ConjuntoP = this.Pizarra(this.ConjuntoQ1);
            this.GamaP = this.Pizarra(this.Gama1);
            this.E_FinalesP = this.Pizarra(this.E_Finales1);
            this.parsearGrafo();
          } else {
            alert("Datos no validos");
          }
        } else alert("Formato ingresado no valido");
      }
    },
    AFD_ER() {
      this.Afd_to_Er(
        this.ConjuntoQ1,
        this.Alfabeto1,
        this.Gama1,
        this.E_Finales1,
        this.E_inicial1
      );
    },
    reset() {
      this.limpiar();
      console.log("Datos borrados.");
      this.E_inicial1 = this.ResetearAutomata(
        this.ConjuntoQ1,
        this.Alfabeto1,
        this.Gama1,
        this.E_inicial1,
        this.E_Finales1
      );
      console.log(
        this.ConjuntoQ1,
        this.Alfabeto1,
        this.Gama1,
        this.E_inicial1,
        this.E_Finales1
      );
      this.parsearGrafo();
    },

    ResetearAutomata(estados, alfabeto, gama, e_inicial, e_finales) {
      estados = estados.splice(0, estados.length);
      alfabeto = alfabeto.splice(0, alfabeto.length);
      gama = gama.splice(0, gama.length);
      e_inicial = null;
      e_finales = e_finales.splice(0, e_finales.length);
      console.log(e_finales);
      return e_inicial;
    },

    ContieneEstado(estados, contenedor) {
      if (!Array.isArray(estados)) {
        if (contenedor.includes(estados)) return true;
        else return false;
      } else {
        for (let i = 0; i < estados.length; i++)
          if (!contenedor.includes(estados[i])) return false;
        return true;
      }
    },

    validar_gama(comparador1, comparador2, a_comparar) {
      for (let i = 0; i < a_comparar.length; i++) {
        if (!comparador1.includes(a_comparar[i][0])) {
          console.log("a");
          return false;
        }
        if (
          !(comparador2.includes(a_comparar[i][1]) || a_comparar[i][1] == "$")
        ) {
          console.log("a_comparar[i][1]", a_comparar[i][1]);
          console.log("b");
          return false;
        }
        if (!comparador1.includes(a_comparar[i][2])) {
          console.log("c");
          return false;
        }
      }
      return true;
    },

    caractervalido(estado) {
      var Er = /[A-Za-z0-9]*/g;
      if (Er.test(estado)) return true;
      {
        return false;
      }
    },

    limpiar() {
      console.clear();
    },

    mostrardatos(conjunto, alfabeto, gama, e_ini, e_final, Nautomata) {
      console.log("Estados " + Nautomata + ":", conjunto);
      console.log("Alfabeto " + Nautomata + ":", alfabeto);
      console.log("Transiciones " + Nautomata + ":", gama);
      console.log("Estados finales " + Nautomata + ":", e_final);
      console.log("Estado inicial " + Nautomata + ":", e_ini);

      console.log(
        "Tabla de estados " + Nautomata + ":",
        this.añadirconex3(this.tabla_estados(conjunto, alfabeto, gama), gama)
      );
    },

    Pizarra(contenido) {
      var pizarra = [];
      for (let i = 0; i < contenido.length; i++) pizarra.push(contenido[i]);
      return pizarra;
    },

    epsilon(transiciones) {
      for (let i = 0; i < transiciones.length; i++)
        if (transiciones[i][1].charCodeAt() == 64)
          transiciones[i][1] = String.fromCharCode(36);
      return transiciones;
    },

    estados3deE(estado, gama) {
      var resultado = [];
      resultado.push(estado);
      for (let i = 0; i < gama.length; i++)
        if (estado == gama[i][0] && gama[i][1] == "$") {
          resultado.push(gama[i][2]);
          estado = gama[i][2];
        }
      return resultado;
    },

    tiene3(estado, gama) {
      for (let i = 0; i < gama.length; i++)
        if (estado == gama[i][0] && gama[i][1] == "$") return true;
      return false;
    },

    copia(gama) {
      var resultado = [];
      for (let i = 0; i < gama.length; i++) {
        var conex = [];
        for (let j = 0; j < 3; j++) conex.push(gama[i][j]);
        resultado.push(conex);
      }
      return resultado;
    },

    estados3alfaconsumido(estado, gama) {
      var respuesta = "";
      var copiag = this.copia(gama);
      while (this.tiene3(estado, copiag)) {
        var estados3 = this.estados3deE(estado, copiag);

        for (let i = estados3.length - 1; i > 0; i--) {
          if (this.tiene3(estados3[i], copiag))
            respuesta += this.estados3alfaconsumido(estados3[i], copiag);
          for (let j = 0; j < copiag.length; j++) {
            if (
              estados3[i] == copiag[j][2] &&
              copiag[j][1] == "$" &&
              copiag[j][0] == estados3[i - 1]
            ) {
              copiag.splice(j, 1);
              j = 0;
              respuesta = respuesta + "," + estados3[i];
            }
          }
        }
      }
      return respuesta;
    },

    estado3alfasinconsumir(estado, alfa, gama) {
      var respuesta = "";
      var copiag = this.copia(gama);
      while (this.tiene3(estado, copiag)) {
        var estados3 = this.estados3deE(estado, copiag);
        for (let i = estados3.length - 1; i > 0; i--) {
          if (this.tiene3(estados3[i], copiag))
            respuesta += this.estado3alfasinconsumir(estados3[i], alfa, copiag);
          for (let j = 0; j < copiag.length; j++) {
            if (estados3[i] == copiag[j][0] && copiag[j][1] == alfa)
              respuesta = respuesta + "," + copiag[j][2];
            if (
              estados3[i] == copiag[j][2] &&
              copiag[j][1] == "$" &&
              copiag[j][0] == estados3[i - 1]
            ) {
              copiag.splice(j, 1);
              j = 0;
            }
          }
        }
      }
      return respuesta;
    },

    añadirconex3(matriz, gama) {
      for (let i = 1; i < matriz.length; i++) {
        for (let j = 1; j < matriz[0].length; j++) {
          var respuesta = "";
          respuesta += this.estados3alfaconsumido(matriz[i][j], gama);
          respuesta += this.estado3alfasinconsumir(
            matriz[i][0],
            matriz[0][j],
            gama
          );
          if (matriz[i][j] != "-") {
            matriz[i][j] += respuesta;
            matriz[i][j] = this.artostr(
              this.Datos_dupli(matriz[i][j].split(","))
            );
          } else {
            if (respuesta != "") {
              matriz[i][j] = respuesta.substring(1, respuesta.length);
              matriz[i][j] = this.artostr(
                this.Datos_dupli(matriz[i][j].split(","))
              );
            }
          }
        }
      }
      return matriz;
    },

    optimizar(estados1, estados2, alfa, gama1, gama2, estadosf) {
      var matriz_d = this.matriz_distinguible(
        this.tabla_estados(estados1, alfa, gama1),
        estados1,
        alfa,
        estadosf
      );
      if (this.equivalencias(matriz_d)) {
        while (this.equivalencias(matriz_d)) {
          var id_d = this.buscar_disti(matriz_d);
          console.log(
            "Matriz distinguible: ",
            this.matriz_distinguible(
              this.tabla_estados(estados1, alfa, gama1),
              estados1,
              alfa,
              estadosf
            )
          );
          console.log("Estados: ", estados1);
          console.log("Alfabeto: ", alfa);
          console.log("Transiciones: ", gama1);
          for (let index = 0; index < gama1.length; index++) {
            if (
              gama1[index][0] == estados1[this.Buscar_id(estados1, id_d[1]) - 1]
            ) {
              gama1.splice(index, 1);
              index = 0;
            }
            if (
              gama1[index][2] == estados1[this.Buscar_id(estados1, id_d[1]) - 1]
            ) {
              var aux = [];
              aux.push(gama1[index][0]);
              aux.push(gama1[index][1]);
              aux.push(estados1[this.Buscar_id(estados1, id_d[0]) - 1]);

              gama1.splice(index, 1, aux);
              index = 0;
            }
          }
          estados1.splice(this.Buscar_id(estados1, id_d[1]) - 1, 1);
          console.log(
            "Matriz distinguible: ",
            this.matriz_distinguible(
              this.tabla_estados(estados1, alfa, gama1),
              estados1,
              alfa,
              estadosf
            )
          );
          console.log("Estados: ", estados1);
          console.log("Alfabeto: ", alfa);
          console.log("Transiciones: ", gama1);

          this.ConjuntoQ3 = this.copiararray(estados1, estados2);
          this.Gama3 = this.copiararray(gama1, gama2);
        }
        this.parsearGrafo();
      } else alert("El automata ya se encuentra en su estado minimo");
    },

    //Funciones de creacion y visualizacion de automatas

    visestado(arreglo) {
      var object = [];
      for (let index = 0; index < arreglo.length; index++) {
        const element = arreglo[index];
        object.push({ id: index + 1, label: element });
      }
      return object;
    },

    alfabetoxestado(arreglo) {
      var object = [];
      arreglo.forEach((element) => {
        object.push({
          from: this.Buscar_id(this.ConjuntoP, element[0]),
          to: this.Buscar_id(this.ConjuntoP, element[2]),
          label: element[1],
        });
      });
      return object;
    },

    _Gama(arreglo) {
      var gama = [];
      for (let index = 0; index < arreglo.length; index++)
        gama.push(arreglo[index].split(","));
      return gama;
    },
    Buscar_id(arreglo, nombre) {
      for (let index = 0; index < arreglo.length; index++) {
        if (nombre == arreglo[index]) return index + 1;
      }
    },

    Datos_dupli(arreglo) {
      for (let index = 0; index < arreglo.length; index++)
        for (let jdex = 0; jdex < arreglo.length; jdex++) {
          if (index != jdex) {
            if (arreglo[index] == arreglo[jdex]) arreglo.splice(jdex, 1);
          }
        }
      return arreglo;
    },
    gama_dupli(arreglo) {
      for (let index = 0; index < arreglo.length; index++)
        for (let jdex = 0; jdex < arreglo.length; jdex++) {
          if (index != jdex) {
            if (this.Comparar(arreglo[index], arreglo[jdex])) {
              arreglo.splice(jdex, 1);
              jdex = 0;
            }
          }
        }
    },

    Comparar(arr1, arr2) {
      for (let z = 0; z < arr1.length; z++) {
        if (arr1[z] == arr2[z]) return true;
      }
      return false;
    },

    graph() {
      console.log("grafito");
      //   node = new vis.DataSet(this.visestado(ConjuntoP));
      //   edge = new vis.DataSet(this.alfabetoxestado(GamaP));
      //   container = document.getElementById("mynetwork");
      //   data = { nodes: node, edges: edge };
      //   options = { edges: { arrows: { to: { enabled: true } } } };
      //   network = new vis.Network(container, data, options);
    },

    //Fin funciones visualizacion y creacion de automata

    tabla_estados(estados, alfabeto, Ftrans) {
      var matriz = [];
      for (let index = 0; index <= estados.length; index++) {
        var columnas = [];
        for (let jdex = 0; jdex <= alfabeto.length; jdex++) {
          if (index == 0 && jdex == 0) columnas.push("n");
          else {
            if (index == 0) columnas.push(alfabeto[jdex - 1]);
            if (jdex == 0) columnas.push(estados[index - 1]);
          }
          if (index != 0 && jdex != 0) {
            var paso = 0;
            for (let i = 0; i < Ftrans.length; i++) {
              if (
                Ftrans[i][0] == columnas[0] &&
                Ftrans[i][1] == matriz[0][jdex]
              ) {
                if (columnas[jdex] == null) columnas.push(Ftrans[i][2]);
                else columnas[jdex] = columnas[jdex] + "," + Ftrans[i][2];
                paso = 1;
              }
            }
            if (paso == 0) columnas.push("-");
          }
        }
        matriz.push(columnas);
      }
      return matriz;
    },

    // Funciones para simplificar afd

    /* function Compatibles() */

    factorial(numero) {
      var resultado = 1;
      while (numero > 0) {
        resultado *= numero;
        numero--;
      }
      return resultado;
    },

    coef_binomial(numero) {
      var resultado =
        this.factorial(numero) /
        (this.factorial(2) * this.factorial(numero - 2));
      return resultado;
    },

    matrizvacia(arreglo) {
      var matriz = [];
      for (let index = 0; index <= arreglo.length; index++) {
        var columnas = [];
        for (let jdex = 0; jdex <= arreglo.length; jdex++) {
          if (index == 0 && jdex == 0) columnas.push("n");
          else {
            if (index == 0) columnas.push(arreglo[jdex - 1]);
            if (jdex == 0) columnas.push(arreglo[index - 1]);
          }
          if (index != 0 && jdex != 0) {
            if (index == jdex) columnas.push(-1);
            else columnas.push(0);
          }
        }
        matriz.push(columnas);
      }
      return matriz;
    },
    matriz_distinguible(matriz, estados, alfa, estados_f) {
      var matriz_resultado = this.matrizvacia(estados);
      var id_i = 1,
        id_f = estados.length,
        iteracion = 0;

      while (iteracion < this.coef_binomial(estados.length)) {
        while (id_i != id_f) {
          if (
            this.final_nofinal(matriz[id_i][0], estados_f) !=
            this.final_nofinal(matriz[id_f][0], estados_f)
          ) {
            matriz_resultado[id_i][id_f] = 1;
            matriz_resultado[id_f][id_i] = 1;
          } else {
            var aux = 1;
            while (aux <= alfa.length) {
              if (
                this.final_nofinal(matriz[id_i][aux], estados_f) !=
                this.final_nofinal(matriz[id_f][aux], estados_f)
              ) {
                matriz_resultado[id_i][id_f] = 1;
                matriz_resultado[id_f][id_i] = 1;
                aux = alfa.length;
              }
              aux++;
            }
          }
          id_f--;
          iteracion++;
        }
        id_i++;
        id_f = estados.length;
      }
      return matriz_resultado;
    },
    afnd_to_afd(matriz, estado_i, estado_f, conjuntoq, alfabeto, gama) {
      estado_i += this.estados3alfaconsumido(estado_i, gama);
      var nuevoQ = [];
      var nuevoG = [];
      var nuevoF = [];
      nuevoQ.push(estado_i);
      for (let i = 0; i < nuevoQ.length; i++) {
        for (let j = 0; j < alfabeto.length; j++) {
          if (nuevoQ[i] != "S") {
            var estadoU = "";
            var estadoaux = nuevoQ[i].split(",");
            /* console.log(estadoaux) */
            for (let k = 0; k < estadoaux.length; k++) {
              if (this.Cdirige(matriz, estadoaux[k], alfabeto[j]) != "-") {
                if (estadoU != "")
                  estadoU =
                    estadoU +
                    "," +
                    this.Cdirige(matriz, estadoaux[k], alfabeto[j]);
                else estadoU += this.Cdirige(matriz, estadoaux[k], alfabeto[j]);
                /* console.log(Cdirige(matriz,estadoaux[k],alfabeto[j])) */
              }
            }
            if (estadoU != "") {
              estadoU = this.artostr(this.Datos_dupli(estadoU.split(",")));
              nuevoG.push(
                this.añadirtransicion(nuevoQ[i], alfabeto[j], estadoU)
              );
              if (this.noexiste(estadoU, nuevoQ)) nuevoQ.push(estadoU);
              if (this.existefinal(estadoU, estado_f)) nuevoF.push(estadoU);
            } else {
              estadoU = "S";
              nuevoG.push(
                this.añadirtransicion(nuevoQ[i], alfabeto[j], estadoU)
              );
              if (this.noexiste(estadoU, nuevoQ)) nuevoQ.push(estadoU);
            }
          } else
            nuevoG.push(
              this.añadirtransicion(nuevoQ[i], alfabeto[j], nuevoQ[i])
            );
        }
      }
      if (this.existefinal(nuevoQ[0], estado_f)) nuevoF.push(nuevoQ[0]);
      var respuesta = [];
      nuevoF = this.Datos_dupli(nuevoF);
      respuesta.push(estado_i);
      respuesta.push(nuevoQ);
      respuesta.push(alfabeto);
      respuesta.push(nuevoG);
      respuesta.push(nuevoF);

      return respuesta;
    },
    final_nofinal(id, estadosf) {
      if (estadosf.includes(id))
        // true = final
        return true;
      //false = nofinal
      else return false;
    },
    buscar_disti(matriz) {
      var ids = [];
      for (let index = 1; index < matriz.length; index++)
        for (let jdex = 1; jdex < matriz.length; jdex++)
          if (matriz[index][jdex] == 0) {
            matriz[index][jdex] = 1;
            matriz[jdex][index] = 1;
            ids.push(matriz[0][index]);
            ids.push(matriz[jdex][0]);
            return ids;
          }
    },
    equivalencias(matriz) {
      //   var ids = [];
      for (let index = 1; index < matriz.length; index++)
        for (let jdex = 1; jdex < matriz.length; jdex++)
          if (matriz[index][jdex] == 0) return true;
      return false;
    },
    EsAFD(estados, alfabeto, gama) {
      for (let i = 0; i < estados.length; i++) {
        var cont = 0;
        for (let j = 0; j < gama.length; j++) {
          if (estados[i] == gama[j][0]) {
            if (this.transicion_repetida(gama[j], gama, j)) cont++;
          }
          if (gama[j][1] == "$") return false;
        }
        if (cont != alfabeto.length) return false;
      }
      return true;
    },
    transicion_repetida(transicion, gama, posicion) {
      for (let i = 0; i < gama.length; i++) {
        if (i != posicion) {
          if (
            transicion[0] == gama[i][0] &&
            transicion[1] == gama[i][1] &&
            transicion[2] == gama[i][2]
          )
            return false;
        }
      }
      return true;
    },
    añadirtransicion(estado_e, alfa, estado_s) {
      var conex = [];
      conex.push(estado_e);
      conex.push(alfa);
      conex.push(estado_s);
      return conex;
    },
    Cdirige(matriz, estado, alfa) {
      for (let i = 1; i < matriz.length; i++)
        for (let j = 1; j < matriz[0].length; j++)
          if (matriz[i][0] == estado && matriz[0][j] == alfa)
            return matriz[i][j];
    },
    soniguales(string1, string2) {
      var str1 = string1.split(",");
      var str2 = string2.split(",");

      if (str1.length != str2.length) return false;
      for (let i = 0; i < str1.length; i++)
        if (!str2.includes(str1[i])) return false;
      return true;
    },
    existefinal(string, arreglo) {
      var strr = string.split(",");
      for (let i = 0; i < strr.length; i++)
        if (arreglo.includes(strr[i])) return true;
      return false;
    },
    noexiste(estado, conjunto) {
      var bitc = 0;
      for (let i = 0; i < conjunto.length; i++)
        if (this.soniguales(conjunto[i], estado)) bitc = 1;
      if (bitc == 1) return false;
      else return true;
    },
    artostr(arreglo) {
      var r = "";
      for (let i = 0; i < arreglo.length; i++) {
        if (i > 0) r = r + "," + arreglo[i];
        else r += arreglo[i];
      }
      return r;
    },
    compararalfabeto(arr1, arr2) {
      if (this.comparararreglo(arr1, arr2) && this.comparararreglo(arr2, arr1))
        return true;
      else return false;
    },
    comparararreglo(arr1, arr2) {
      for (let i = 0; i < arr1.length; i++) {
        if (!this.existealfa(arr1[i], arr2)) return false;
      }
      return true;
    },
    existealfa(string, arreglo) {
      var strr = string.split("");
      for (let i = 0; i < strr.length; i++)
        if (!arreglo.includes(strr[i])) return false;
      return true;
    },
    //Funciones para obetener ER de un AFD
    Afd_to_Er(estados, alfabeto, gama, e_finales, e_inicial) {
      if (this.TieneEntradas(e_inicial, gama))
        e_inicial = this.NuevoInicial(estados, gama, e_inicial);
      if (this.TieneSalidas(e_finales, gama))
        e_finales = this.NuevoFinal(estados, gama, e_finales);

      while (this.TieneSalidas(e_inicial, gama) && estados.length > 2) {
        var eliminar = this.Terna_estados(e_inicial, gama);
        var estados_s = this.Salidas_de_x(eliminar[1], gama);
        var estados_e = this.Entradas_de_x(eliminar[1], gama);
        console.log(eliminar, estados_e, estados_s);
        for (let i = 0; i < estados_e.length; i++) {
          for (let j = 0; j < estados_s.length; j++) {
            console.log(estados_e[i], estados_s[j]);
            this.mostrargama(gama);
            var resultante = this.simplificarexpresion(
              this.Uniones(estados_e[i], gama, eliminar[1])
            );
            console.log(resultante);
            resultante += this.simplificarexpresion(
              this.Clausuras(eliminar[1], gama)
            );
            console.log(resultante);
            resultante += this.simplificarexpresion(
              this.Uniones(eliminar[1], gama, estados_s[j])
            );
            console.log(resultante);
            gama.push(
              this.añadirtransicion(estados_e[i], resultante, estados_s[j])
            );
            console.log(
              this.añadirtransicion(estados_e[i], resultante, estados_s[j])
            );
          }
        }
        var er = this.Uniones(eliminar[0], gama, eliminar[2]);
        gama = this.EliminarT_de_x_y(eliminar[0], eliminar[2], gama);
        gama.push(this.añadirtransicion(eliminar[0], er, eliminar[2]));

        gama = this.EliminarTransiciones_de_x(eliminar[1], gama);
        //gama=EliminarT_de_x_y(eliminar[0],eliminar[1],gama)
        //gama=EliminarTransicionEspecifica(eliminar[0],ObtenerAlfa(eliminar[0],gama,eliminar[1]),eliminar[1],gama)
        console.log(gama);
        estados = this.EliminarEstado_x(eliminar[1], estados);
        console.log(estados);
      }

      this.mostrardatos(estados, alfabeto, gama, e_inicial, e_finales, "ER");
      this.ConjuntoP = this.Pizarra(estados);
      this.GamaP = this.Pizarra(gama);
      this.parsearGrafo();
    },
    mostrargama(gama) {
      for (let i = 0; i < gama.length; i++) console.log(gama[i]);
    },
    Entradas_de_x(estado, gama) {
      var Conexiones = [];
      for (let i = 0; i < gama.length; i++) {
        if (estado !== gama[i][0]) {
          if (estado === gama[i][2]) {
            if (!Conexiones.includes(gama[i][0])) Conexiones.push(gama[i][0]);
          }
        }
      }
      return Conexiones;
    },
    Salidas_de_x(estado, gama) {
      var Conexiones = [];
      for (let i = 0; i < gama.length; i++) {
        if (
          estado == gama[i][0] &&
          estado != gama[i][2] &&
          !Conexiones.includes(gama[i][2])
        )
          Conexiones.push(gama[i][2]);
      }
      return Conexiones;
    },
    EliminarT_de_x_y(estado1, estado2, gama) {
      for (let i = 0; i < gama.length; i++) {
        if (estado1 == gama[i][0] && estado2 == gama[i][2]) {
          gama.splice(i, 1);
          i = -1;
        }
      }
      return gama;
    },
    EliminarTransicionEspecifica(estado1, alfa, estado2, gama) {
      for (let i = 0; i < gama.length; i++) {
        if (
          estado1 == gama[i][0] &&
          alfa == gama[i][1] &&
          estado2 == gama[i][2]
        ) {
          gama.splice(i, 1);
          i = 0;
        }
      }
      return gama;
    },
    EliminarTransiciones_de_x(estado, gama) {
      for (let i = 0; i < gama.length; i++) {
        if (gama[i][0] == estado || gama[i][2] == estado) {
          gama.splice(i, 1);
          i = -1;
        }
      }
      return gama;
    },
    EliminarEstado_x(estado, conjunto) {
      conjunto.splice(conjunto.indexOf(estado), 1);
      return conjunto;
    },
    Clausuras(estado, gama) {
      var str = "";
      for (let i = 0; i < gama.length; i++) {
        if (estado == gama[i][0] && estado == gama[i][2]) {
          if (str != "") str = str + "+" + gama[i][1];
          else str = str + "(" + gama[i][1];
        }
      }
      if (str != "") str += ")*";
      return str;
    },
    Uniones(estado1, gama, estado2) {
      var str = "";
      var bit_parentesis = 0;
      for (let i = 0; i < gama.length; i++) {
        if (estado1 == gama[i][0] && estado2 == gama[i][2]) {
          if (str != "") str = str + "+" + gama[i][1];
          else {
            if (gama[i][1][0] == "(") {
              str = str + gama[i][1];
              bit_parentesis = 1;
            } else str = str + "(" + gama[i][1];
          }
        }
      }
      if (str.length > 2) {
        if (bit_parentesis == 0) str += ")";
      } else str = str.substring(1, str.length);
      return str;
    },
    simplificarexpresion(expresion) {
      var er = expresion.split("");
      var erstr;
      for (let i = 0; i < er.length; i++) {
        if (er[i] == "$") {
          er.splice(i, 1);
          i = -1;
          erstr = this.ar_to_str(er);
        }
      }
      if (erstr != null) return erstr;
      return expresion;
    },
    ar_to_str(arr) {
      var resp = "";
      for (let i = 0; i < arr.length; i++) resp += arr[i];
      return resp;
    },
    ObtenerAlfa(estado1, gama, estado2) {
      for (let i = 0; i < gama.length; i++)
        if (gama[i][0] == estado1 && estado2 == gama[i][2]) return gama[i][1];
    },
    NuevoFinal(estados, gama, e_fin) {
      estados.push("Nf");
      for (let i = 0; i < e_fin.length; i++)
        gama.push(this.añadirtransicion(e_fin[i], "$", "Nf"));
      e_fin.splice(0, e_fin.length, "Nf");

      return e_fin;
    },
    NuevoInicial(estados, gama, e_ini) {
      estados.splice(0, 0, "Ni");
      gama.push(this.añadirtransicion("Ni", "$", e_ini));
      return "Ni";
    },
    TieneEntradas(estado, gama) {
      for (let i = 0; i < gama.length; i++)
        if (estado == gama[i][2]) return true;
      return false;
    },
    TieneSalidas(estados, gama) {
      if (Array.isArray(estados)) {
        for (let i = 0; i < estados.length; i++)
          for (let j = 0; j < gama.length; j++)
            if (estados[i] == gama[j][0]) return true;
        return false;
      } else {
        for (let j = 0; j < gama.length; j++)
          if (estados == gama[j][0]) return true;
        return false;
      }
    },
    Terna_estados(estado, gama) {
      var estados = [];
      estados.push(estado);
      var segundoestado = 0;
      for (let i = 0; i < gama.length; i++) {
        if (gama[i][0] == estado) {
          if (!estados.includes(gama[i][2])) {
            if (segundoestado == 0) {
              if (this.TieneSalidas(gama[i][2], gama)) {
                estado = gama[i][2];
                estados.push(estado);
                i = -1;
                segundoestado = 1;
              }
            } else {
              estado = gama[i][2];
              estados.push(estado);
              if (estados.length == 3) return estados;
            }
          }
        }
      }
    },
  },
};
</script>