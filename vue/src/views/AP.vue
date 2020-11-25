<template>
  <div>
    <v-checkbox v-model="mostrar" label="Mostrar instrucciones"></v-checkbox>
    <div v-if="mostrar" style="background-color: #d9ad26">
      <h4>Instrucciones:</h4>
      <table class="table">
        <caption></caption>
        <thead>
          <tr>
            <th scope="col">Para:</th>
            <th scope="col">Como hacerlo:</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">Ingresar los estados de los autómatas.</th>
            <td>
              En el recuadro se han de ingresar valores alfanuméricos, letras o
              números separados por una ",".
            </td>
          </tr>
          <tr>
            <th scope="row">Ingresar el alfabeto de los autómatas.</th>
            <td>
              En el recuadro se han de ingresar valores alfanuméricos, letras o
              números separados por una ",".
            </td>
          </tr>
          <tr>
            <th scope="row">Ingresar el estado inicial del autómata.</th>
            <td>
              En el recuadro se ha de ingresar un solo valor el cual corresponde
              al estado inicial, este debe pertenecer al conjunto de estados
              ingresado anteriormente.
            </td>
          </tr>
          <tr>
            <th scope="row">Ingresar las Funciones de transición.</th>
            <td>
              Será de la forma estado del autómata, alfabeto, estado del
              autómata, para agregar más de una transición se han de separar por
              ";", los valores ingresador han de extistir en los estados y en el
              alfabeto (Para ingresar una conexión vacía tipear un "@" en el
              apartado del alfabeto "estado,@,estado").
            </td>
          </tr>
          <tr>
            <th scope="row">Ingresar los Estados Finales de los autómatas.</th>
            <td>
              Se han de ingresan los estados finales sepadaros mediante una ","
              y siempre y cuando estos pertenezcan al conjunto de estados.
            </td>
          </tr>
          <tr>
            <th scope="row">Concatenación de los autómatas.</th>
            <td>
              Una vez ingresados los autómatas, estos se referenciaran como un
              "1" para el autómata 1 y 2 respectivamente.
            </td>
          </tr>
          <tr>
            <th scope="row">Ejemplo de la clase.</th>
            <td>
              Conjunto de estados: q1,q2,q3,q4,q5 , Alfabeto: a,b, Estado
              Inicial: q5, Función de transición:
              q5,a,q4;q5,b,q3;q4,a,q4;q4,b,q2;q3,a,q4;q3,b,q1;q2,a,q4;q2,b,q1;q1,a,q1;q1,b,q1,
              Estado(s) final(es): q2,q3,q4,q5.
            </td>
          </tr>
          <tr>
            <th scope="row">Detalles del algoritmo</th>
            <td>
              Para ver los resultados en detalle (conjunto de estados, alfabeto,
              estado inicial, transiciones, estados finales) puede verlos desde
              la consola haciendo click derecho/inspeccionar elemento en la
              pestaña console
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <Grafo :key="recargarGrafo" :grafo="grafo" />
    <h1 class="title">Datos autómatas</h1>
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
          <v-subheader>Formato: q1,q2,q3,...,qn</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Alfabeto pila</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-text-field
            name="Alfabetopila"
            outlined
            dense
            placeholder="x,y,z..."
            v-model="Alfabetopila"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato:1,2,3,...,n</v-subheader>
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
          <v-subheader>Formato:1,2,3,...,n</v-subheader>
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
          <v-subheader>Formato: q1</v-subheader>
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
            placeholder="q/a/q;"
            v-model="GamaF"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: q1,a,q2;q1,b,q1;...qn,n,qm</v-subheader>
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
            placeholder="q1,q2,q3,q4"
            v-model="Finales"
          ></v-text-field>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: q1,q2,...,qn</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="12" style="display: flex; justify-content: center">
          <v-btn
            color="secondary"
            depressed
            raised
            @click="this.ValidarEntrada1"
            >Ingresar AP1</v-btn
          >
          <v-btn
            color="secondary"
            depressed
            raised
            @click="this.ValidarEntrada2"
            >Ingresar AP2</v-btn
          >
          <v-btn color="primary" depressed outlined raised @click="this.reset"
            >Limpiar</v-btn
          >
        </v-col>
      </v-row>
    </v-container>

    <h1 class="title">Funciones para ambos autómatas</h1>
    <v-container fluid>
      <v-row style="display: flex; justify-content: center">
        <v-col cols="1">
          <v-subheader>Inicio</v-subheader>
        </v-col>
        <v-col cols="2">
          <v-text-field
            name="concatenarinicio"
            outlined
            dense
            placeholder="Inicio"
            v-model="Conca1"
          ></v-text-field>
        </v-col>
        <v-col cols="1">
          <v-subheader>Final</v-subheader>
        </v-col>
        <v-col cols="2">
          <v-text-field
            name="concatenarfinal"
            outlined
            dense
            placeholder="Final"
            v-model="Conca2"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12" style="display: flex; justify-content: center">
          <v-btn color="secondary" depressed raised @click="this.Union"
            >Unión</v-btn
          >
          <v-btn color="primary" depressed raised @click="this.Concatenar"
            >Concatenación</v-btn
          >
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
import Grafo from "../components/Grafo.vue";

export default {
  name: "AP",
  components: { Grafo },
  data() {
    return {
      grafo: {},
      recargarGrafo: false,
      mostrar: false,
      Nodos: null,
      Alfabeto: null,
      Alfabetopila: null,
      Inicial: null,
      GamaF: null,
      Conca1: null,
      Conca2: null,
      Finales: null,
      E_inicial1: "",
      E_inicial2: "",
      E_inicial3: null,
      E_inicialP: null,
      AlfabetoP: [],
      ConjuntoQ1: [],
      ConjuntoQ2: [],
      ConjuntoQ3: [],
      ConjuntoP: [],
      Alfabeto1: [],
      Alfabeto2: [],
      Alfabeto3: [],
      Gama1: [],
      Gama2: [],
      Gama3: [],
      GamaP: [],
      E_Finales1: [],
      E_Finales2: [],
      E_Finales3: [],
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
      if (this.ConjuntoQ3 && this.Gama3 != null) {
        var aristas = [];
        var letras = this.Alfabeto.split(",");
        var nodosF = this.Finales.split(",");
        nodosF.push(this.Conca2);
        for (var i = 0; i < this.Gama3.length; i++) {
          var arista = this.Gama3[i];
          aristas.push({
            origen: arista[0],
            destino: arista[2],
            alfabeto: arista[1],
          });
        }
        this.grafo = {
          nodos: this.ConjuntoQ3,
          alfabeto: letras,
          inicial: this.Conca1,
          aristas: aristas,
          finales: nodosF,
        };
        console.log("grafo", this.grafo);
        this.recargarGrafo = !this.recargarGrafo;
      }
    },
    ValidarEntrada1() {
      this.limpiar();

      if (this.ConjuntoQ1.length > 0)
        this.E_inicial1 = this.ResetearAutomata(
          this.ConjuntoQ1,
          this.Alfabeto1,
          this.Gama1,
          this.E_inicial1,
          this.E_Finales1
        );

      this.E_inicial1 = this.Inicial;
      var Q = this.Nodos;
      var A = this.Alfabeto;
      var P = this.Alfabetopila;
      var G = this.GamaF;
      var F = this.Finales;

      let valQ = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valP = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valA = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valF = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valG = /^[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+(;[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+)*$/g;

      if (
        Q == null ||
        A == null ||
        P == null ||
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
          valP.test(P) &&
          this.caractervalido(this.E_inicial1)
        ) {
          this.ConjuntoQ1 = this.Datos_dupli(Q.split(","));
          this.Alfabeto1 = this.Datos_dupli(A.split(","));
          this.E_Finales1 = this.Datos_dupli(F.split(","));
          this.AlfabetoP = this.Datos_dupli(P.split(","));
          this.Gama1 = this.elemento(this.Datos_dupli(G.split(";")));
          var idFinales = this.ids(this.E_Finales1, this.ConjuntoQ1);
          var idGama = this.ids_gama(this.Gama1, this.ConjuntoQ1);
          var id_ini = this.Buscar_id(this.ConjuntoQ1, this.E_inicial1) - 1;
          if (this.validar_estadosx(this.ConjuntoQ1, this.E_inicial1)) {
            if (
              this.validar_estadosx(this.ConjuntoQ1, this.E_Finales1) &&
              this.validar_gama(
                this.ConjuntoQ1,
                this.Alfabeto1,
                this.AlfabetoP,
                this.Gama1
              )
            ) {
              this.ConjuntoQ1 = this.cambiarcaracter(
                this.ConjuntoQ2,
                this.ConjuntoQ1
              );
              this.E_inicial1 = this.ConjuntoQ1[id_ini];
              this.E_Finales1 = this.e_finales(idFinales, this.ConjuntoQ1);
              this.Gama1 = this.gama(idGama, this.ConjuntoQ1);
              this.ConjuntoQ1.splice(0, 0, this.E_inicial1);
              this.ConjuntoQ1 = this.Datos_dupli(this.ConjuntoQ1);

              this.Gama1 = this.epsilon(this.Gama1);
              this.ConjuntoQ3 = this.copiararray(
                this.ConjuntoQ1,
                this.ConjuntoQ2
              );
              this.Gama3 = this.copiararray(this.Gama1, this.Gama2);
              this.Alfabeto3 = this.copiararray(this.Alfabeto1, this.Alfabeto2);
              this.E_Finales3 = this.copiararray(
                this.E_Finales1,
                this.E_Finales2
              );

              this.mostrardatos(
                this.ConjuntoQ1,
                this.Alfabeto1,
                this.Gama1,
                this.E_inicial1,
                this.E_Finales1,
                "A1"
              );

              this.parsearGrafo();
            } else {
              alert(
                "Lo datos ingresados no validos, deben estar contenidos en el alfabeto o en los estados"
              );
              this.E_inicial1 = this.ResetearAutomata(
                this.ConjuntoQ1,
                this.Alfabeto1,
                this.Gama1,
                this.E_inicial1,
                this.E_Finales1
              );
            }
          } else {
            alert(
              "Lo datos ingresados no validos, el estado inicial debe estar contenido en el conjunto de estados"
            );
            this.E_inicial1 = this.ResetearAutomata(
              this.ConjuntoQ1,
              this.Alfabeto1,
              this.Gama1,
              this.E_inicial1,
              this.E_Finales1
            );
          }
        } else {
          alert("Formato ingresado no valido");
        }
      }
    },
    elemento(arr) {
      var g = [];
      for (let i = 0; i < arr.length; i++) {
        var aux = arr[i].split(",");
        g.push(this.añadirT(aux[0], aux[1].split("/"), aux[2]));
      }
      return g;
    },
    añadirT(es1, ar, es2) {
      var r = [];
      r.push(es1);
      for (let i = 0; i < ar.length; i++) r.push(ar[i]);
      r.push(es2);
      return r;
    },
    ValidarEntrada2() {
      this.limpiar();
      if (this.ConjuntoQ2.length > 0) {
        this.E_inicial2 = this.ResetearAutomata(
          this.ConjuntoQ2,
          this.Alfabeto2,
          this.Gama2,
          this.E_inicial2,
          this.E_Finales2
        );
      }

      this.E_inicial2 = this.Inicial;
      var Q = this.Nodos;
      var A = this.Alfabeto;
      var P = this.Alfabetopila;
      var G = this.GamaF;
      var F = this.Finales;

      let valQ = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valA = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valP = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valF = /^[a-zA-Z0-9]+(,[a-zA-Z0-9]+)*$/g;
      let valG = /^[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+(;[a-zA-Z0-9]+[,](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[/](@|[a-zA-Z0-9]+)[,][a-zA-Z0-9]+)*$/g;

      if (
        Q == null ||
        A == null ||
        G == null ||
        this.E_inicial2 == null ||
        P == null ||
        F == null
      )
        alert("Hay campos en blanco");
      else {
        if (
          valQ.test(Q) &&
          valA.test(A) &&
          valG.test(G) &&
          valF.test(F) &&
          valP.test(P) &&
          this.caractervalido(this.E_inicial2)
        ) {
          this.ConjuntoQ2 = this.Datos_dupli(Q.split(","));
          this.Alfabeto2 = this.Datos_dupli(A.split(","));
          this.AlfabetoP = this.Datos_dupli(P.split(","));
          this.E_Finales2 = this.Datos_dupli(F.split(","));
          this.Gama2 = this.elemento(this.Datos_dupli(G.split(";")));
          var idFinales = this.ids(this.E_Finales2, this.ConjuntoQ2);
          var idGama = this.ids_gama(this.Gama2, this.ConjuntoQ2);
          var id_ini = this.Buscar_id(this.ConjuntoQ2, this.E_inicial2) - 1;
          if (this.validar_estadosx(this.ConjuntoQ2, this.E_inicial2)) {
            if (
              this.validar_estadosx(this.ConjuntoQ2, this.E_Finales2) &&
              this.validar_gama(
                this.ConjuntoQ2,
                this.Alfabeto2,
                this.AlfabetoP,
                this.Gama2
              )
            ) {
              this.ConjuntoQ2 = this.cambiarcaracter(
                this.ConjuntoQ1,
                this.ConjuntoQ2
              );

              this.E_inicial2 = this.ConjuntoQ2[id_ini];
              this.E_Finales2 = this.e_finales(idFinales, this.ConjuntoQ2);
              this.Gama2 = this.gama(idGama, this.ConjuntoQ2);
              this.ConjuntoQ2.splice(0, 0, this.E_inicial2);
              this.ConjuntoQ2 = this.Datos_dupli(this.ConjuntoQ2);

              this.Gama2 = this.epsilon(this.Gama2);

              this.ConjuntoQ3 = this.copiararray(
                this.ConjuntoQ1,
                this.ConjuntoQ2
              );
              this.Gama3 = this.copiararray(this.Gama1, this.Gama2);
              this.Alfabeto3 = this.copiararray(this.Alfabeto1, this.Alfabeto2);
              this.E_Finales3 = this.copiararray(
                this.E_Finales1,
                this.E_Finales2
              );

              this.mostrardatos(
                this.ConjuntoQ2,
                this.Alfabeto2,
                this.Gama2,
                this.E_inicial2,
                this.E_Finales2,
                "A2"
              );

              this.parsearGrafo();
            } else {
              alert(
                "Lo datos ingresados no validos, deben estar contenidos en el alfabeto o en los estados"
              );
              this.E_inicial2 = this.ResetearAutomata(
                this.ConjuntoQ2,
                this.Alfabeto2,
                this.Gama2,
                this.E_inicial2,
                this.E_Finales2
              );
            }
          } else {
            alert(
              "Lo datos ingresados no validos, el estado inicial debe estar contenido en el conjunto de estados"
            );
            this.E_inicial2 = this.ResetearAutomata(
              this.ConjuntoQ2,
              this.Alfabeto2,
              this.Gama2,
              this.E_inicial2,
              this.E_Finales2
            );
          }
        } else {
          alert("Formato ingresado no valido");
        }
      }
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
      this.E_inicial2 = this.ResetearAutomata(
        this.ConjuntoQ2,
        this.Alfabeto2,
        this.Gama2,
        this.E_inicial2,
        this.E_Finales2
      );
      console.log(
        this.ConjuntoQ2,
        this.Alfabeto2,
        this.Gama2,
        this.E_inicial2,
        this.E_Finales2
      );
      this.E_inicial3 = this.ResetearAutomata(
        this.ConjuntoQ3,
        this.Alfabeto3,
        this.Gama3,
        this.E_inicial3,
        this.E_Finales3
      );
      console.log(
        this.ConjuntoQ3,
        this.Alfabeto3,
        this.Gama3,
        this.E_inicial3,
        this.E_Finales3
      );
      this.E_inicialP = this.ResetearAutomata(
        this.ConjuntoP,
        [],
        this.GamaP,
        this.E_inicialP,
        this.E_FinalesP
      );
      console.log(
        this.ConjuntoP,
        [],
        this.GamaP,
        this.E_inicialP,
        this.E_FinalesP
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
    validar_estadosx(comparador, a_comparar) {
      if (Array.isArray(a_comparar)) {
        for (let i = 0; i < a_comparar.length; i++) {
          if (!comparador.includes(a_comparar[i])) return false;
        }
      } else if (!comparador.includes(a_comparar)) return false;
      return true;
    },
    //                    conjuntoQ  Alfabeto  AlfabetoP Gama
    validar_gama(comparador1, comparador2, comparador3, a_comparar) {
      for (let i = 0; i < a_comparar.length; i++) {
        if (!comparador1.includes(a_comparar[i][0])) return false;
        if (
          !(comparador2.includes(a_comparar[i][1]) || a_comparar[i][1] == "@")
        )
          return false;
        if (
          !(comparador3.includes(a_comparar[i][2]) || a_comparar[i][2] == "@")
        )
          return false;
        if (
          !(comparador3.includes(a_comparar[i][3]) || a_comparar[i][3] == "@")
        )
          return false;
        if (!comparador1.includes(a_comparar[i][4])) return false;
      }
      return true;
    },
    limpiar() {
      //   console.clear();
    },
    mostrardatos(conjunto, alfabeto, gama, e_ini, e_final, Nautomata) {
      console.log("Estados " + Nautomata + ":", conjunto);
      console.log("Alfabeto " + Nautomata + ":", alfabeto);
      console.log("Transiciones " + Nautomata + ":", gama);
      console.log("Estados finales " + Nautomata + ":", e_final);
      console.log("Estado inicial " + Nautomata + ":", e_ini);
    },
    Union() {
      this.limpiar();
      if (this.ConjuntoQ1.length > 0 && this.ConjuntoQ2.length > 0) {
        if (this.compararalfabeto(this.Alfabeto1, this.Alfabeto2)) {
          this.mostrardatos(
            this.ConjuntoQ1,
            this.Alfabeto1,
            this.Gama1,
            this.E_inicial1,
            this.E_Finales1,
            "A1"
          );
          this.mostrardatos(
            this.ConjuntoQ2,
            this.Alfabeto2,
            this.Gama2,
            this.E_inicial2,
            this.E_Finales2,
            "A2"
          );

          var inicio1 = this.ConjuntoQ1[0];
          var inicio2 = this.ConjuntoQ2[0];

          this.E_inicialCombi = "X";

          this.ConjuntoCombi = this.copiararray(
            this.ConjuntoQ1,
            this.ConjuntoQ2
          );
          this.ConjuntoCombi.splice(0, 0, this.E_inicialCombi);

          this.GamaCombi = this.copiararray(this.Gama1, this.Gama2);

          this.GamaCombi.splice(
            0,
            0,
            this.añadirtransicion(this.E_inicialCombi, "@", "@", "@", inicio1)
          );
          this.GamaCombi.splice(
            0,
            0,
            this.añadirtransicion(this.E_inicialCombi, "@", "@", "@", inicio2)
          );

          this.GamaCombi = this.epsilon(this.GamaCombi);

          this.E_FinalesCombi = this.copiararray(
            this.E_Finales1,
            this.E_Finales2
          );

          this.ConjuntoQ3 = this.copiararray(this.ConjuntoCombi, []);
          this.Gama3 = this.copiararray(this.GamaCombi, []);
          this.Alfabeto3 = this.copiararray(this.Alfabeto1, []);
          this.E_Finales3 = this.copiararray(this.E_FinalesCombi, []);

          this.mostrardatos(
            this.ConjuntoCombi,
            this.Alfabeto1,
            this.GamaCombi,
            this.E_inicialCombi,
            this.E_FinalesCombi,
            "Au"
          );
          this.parsearGrafo();
        } else alert("Los automatas no tienen coincidencias en sus alfabetos");
      } else alert("Debe ingresar ambos automatas");
    },
    epsilon(transiciones) {
      for (let i = 0; i < transiciones.length; i++) {
        if (transiciones[i][1].charCodeAt() == 64)
          transiciones[i][1] = String.fromCharCode(36);
        if (transiciones[i][2].charCodeAt() == 64)
          transiciones[i][2] = String.fromCharCode(36);
        if (transiciones[i][3].charCodeAt() == 64)
          transiciones[i][3] = String.fromCharCode(36);
      }
      return transiciones;
    },
    Concatenar() {
      this.limpiar();
      if (this.ConjuntoQ1.length > 0 && this.ConjuntoQ2.length > 0) {
        if (this.compararalfabeto(this.Alfabeto1, this.Alfabeto2)) {
          var a1 = this.Conca1;
          var a2 = this.Conca2;
          if (a1.length > 0 && a2.length > 0) {
            if (
              (a1 == "1" || a1 == "2") &&
              (a2 == "1" || a2 == "2") &&
              a1 != a2
            ) {
              if (a1 == "1") {
                this.mostrardatos(
                  this.ConjuntoQ1,
                  this.Alfabeto1,
                  this.Gama1,
                  this.E_inicial1,
                  this.E_Finales1,
                  "A1"
                );
                this.mostrardatos(
                  this.ConjuntoQ2,
                  this.Alfabeto2,
                  this.Gama2,
                  this.E_inicial2,
                  this.E_Finales2,
                  "A2"
                );

                this.ConjuntoQ1.push("Ni");
                this.ConjuntoQ1.push("Nf");

                this.ConjuntoCombi = this.copiararray(
                  this.ConjuntoQ1,
                  this.ConjuntoQ2
                );
                this.GamaCombi = this.dopiararray(this.Gama1, this.Gama2);
                this.E_FinalesCombi = this.copiararray(
                  this.E_Finales1,
                  this.E_Finales2
                );

                this.E_inicialCombi = "Ni";

                this.GamaCombi.splice(
                  0,
                  0,
                  this.añadirtransicion("Ni", "@", "@", "P", this.E_inicial1)
                );

                var copia_e_f = this.copiararray(this.E_Finales1, []);

                for (let i = 0; i < copia_e_f.length; i++) {
                  this.GamaCombi.splice(
                    0,
                    0,
                    this.añadirtransicion(copia_e_f[i], "@", "P", "@", "Nf")
                  );
                  copia_e_f.splice(i, 1);
                  this.E_FinalesCombi.splice(i, 1);
                  i = -1;
                }

                this.GamaCombi.push(
                  this.añadirtransicion("Nf", "@", "@", "@", this.E_inicial2)
                );

                this.GamaCombi = this.epsilon(this.GamaCombi);

                this.ConjuntoQ3 = this.copiararray(this.ConjuntoCombi, []);
                this.Gama3 = this.copiararray(this.GamaCombi, []);
                this.Alfabeto3 = this.copiararray(this.Alfabeto1, []);
                this.E_Finales3 = this.copiararray(this.E_FinalesCombi, []);
                this.mostrardatos(
                  this.ConjuntoCombi,
                  this.Alfabeto1,
                  this.GamaCombi,
                  this.E_inicialCombi,
                  this.E_FinalesCombi,
                  "Ac"
                );
                this.parsearGrafo();
              } else {
                this.mostrardatos(
                  this.ConjuntoQ2,
                  this.Alfabeto2,
                  this.Gama2,
                  this.E_inicial2,
                  this.E_Finales2,
                  "A2"
                );
                this.mostrardatos(
                  this.ConjuntoQ1,
                  this.Alfabeto1,
                  this.Gama1,
                  this.E_inicial1,
                  this.E_Finales1,
                  "A1"
                );

                this.ConjuntoQ2.push("Ni");
                this.ConjuntoQ2.push("Nf");

                this.ConjuntoCombi = this.copiararray(
                  this.ConjuntoQ2,
                  this.ConjuntoQ1
                );
                this.GamaCombi = this.copiararray(this.Gama2, this.Gama1);
                this.E_FinalesCombi = this.copiararray(
                  this.E_Finales2,
                  this.E_Finales1
                );

                this.E_inicialCombi = "Ni";

                this.GamaCombi.splice(
                  0,
                  0,
                  this.añadirtransicion("Ni", "@", "@", "P", this.E_inicial2)
                );

                copia_e_f = this.copiararray(this.E_Finales2, []);

                for (let i = 0; i < copia_e_f.length; i++) {
                  this.GamaCombi.splice(
                    0,
                    0,
                    this.añadirtransicion(copia_e_f[i], "@", "P", "@", "Nf")
                  );
                  copia_e_f.splice(i, 1);
                  this.E_FinalesCombi.splice(i, 1);
                  i = -1;
                }

                this.GamaCombi.push(
                  this.añadirtransicion("Nf", "@", "@", "@", this.E_inicial1)
                );

                this.GamaCombi = this.epsilon(this.GamaCombi);

                this.ConjuntoQ3 = this.copiararray(this.ConjuntoCombi, []);
                this.Gama3 = this.copiararray(this.GamaCombi, []);
                this.Alfabeto3 = this.copiararray(this.Alfabeto1, []);
                this.E_Finales3 = this.copiararray(this.E_FinalesCombi, []);
                this.mostrardatos(
                  this.ConjuntoCombi,
                  this.Alfabeto1,
                  this.GamaCombi,
                  this.E_inicialCombi,
                  this.E_FinalesCombi,
                  "Ac"
                );
                this.parsearGrafo();
              }
            } else
              alert(
                "Los automatas ingresados no coinciden con [1,2] o ingreso el mismo automata dos veces"
              );
          } else alert("No deben quedar en blanco los campos de concatenacion");
        } else alert("No comparten concordancias en sus alfabetos");
      } else alert("Debe ingresar ambos automatas");
    },
    //                          q0,r0
    comparar_eini(estado1, estado2) {
      if (estado1 != "" && estado2 != "") {
        if (estado1 == estado2) {
          if (
            estado2[0].charCodeAt() == 57 ||
            estado2[0].charCodeAt() == 90 ||
            estado2[0].charCodeAt() == 122
          )
            estado2 = estado2.replace(
              estado2[0],
              String.fromCharCode(estado2[0].charCodeAt() - 1)
            );
          else
            estado2 = estado2.replace(
              estado2[0],
              String.fromCharCode(estado2[0].charCodeAt() + 1)
            );
          return estado2;
        } else return estado1;
      }
      return estado1;
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
    copiararray(datos1, datos2) {
      var resultado = [];
      for (let index = 0; index < datos1.length + datos2.length; index++) {
        if (index < datos1.length) resultado.push(datos1[index]);
        else resultado.push(datos2[index - datos1.length]);
      }
      return resultado;
    },
    cambiarcaracter(estados1, estados2) {
      for (let i = 0; i < estados1.length; i++) {
        if (estados2.includes(estados1[i])) {
          var indice = estados2.indexOf(estados1[i]);
          var aux = estados2[indice];
          while (estados2.includes(aux) || estados1.includes(aux)) {
            if (
              aux[0].charCodeAt() == 57 ||
              aux[0].charCodeAt() == 90 ||
              aux[0].charCodeAt() == 122
            ) {
              if (aux[0].charCodeAt() == 57) {
                aux = aux.replace(
                  aux[0],
                  String.fromCharCode(aux[0].charCodeAt() + 8)
                );
              }
              if (aux[0].charCodeAt() == 90) {
                aux = aux.replace(
                  aux[0],
                  String.fromCharCode(aux[0].charCodeAt() + 7)
                );
              }
              if (aux[0].charCodeAt() == 122) {
                aux = aux.replace(
                  aux[0],
                  String.fromCharCode(aux[0].charCodeAt() - 74)
                );
              }
            } else
              aux = aux.replace(
                aux[0],
                String.fromCharCode(aux[0].charCodeAt() + 1)
              );
          }
          estados2[indice] = aux;
        }
      }
      return estados2;
    },

    //               nuevas funciones
    ids(estados, conjunto) {
      var ids = [];
      for (let i = 0; i < conjunto.length; i++) {
        if (conjunto.includes(estados[i]))
          ids.push(conjunto.indexOf(estados[i]));
      }
      return ids;
    },
    e_finales(ids, conjunto) {
      var e_finales = [];
      for (let i = 0; i < ids.length; i++) e_finales.push(conjunto[ids[i]]);
      return e_finales;
    },
    ids_gama(gama, conjunto) {
      var gamaN = [];
      for (let i = 0; i < gama.length; i++)
        if (conjunto.includes(gama[i][0]) && conjunto.includes(gama[i][4]))
          gamaN.push(
            this.añadirtransicion(
              conjunto.indexOf(gama[i][0]),
              gama[i][1],
              gama[i][2],
              gama[i][3],
              conjunto.indexOf(gama[i][4])
            )
          );
      return gamaN;
    },
    gama(ids, conjunto) {
      var gama_r = [];
      for (let i = 0; i < ids.length; i++)
        gama_r.push(
          this.añadirtransicion(
            conjunto[ids[i][0]],
            ids[i][1],
            ids[i][2],
            ids[i][3],
            conjunto[ids[i][4]]
          )
        );
      return gama_r;
    },
    //               nuevas funciones/>

    cambiarcaractergama(g1, g2) {
      for (let i = 0; i < g1.length; i++)
        for (let j = 0; j < g2.length; j++) {
          if (g1[i][0] == g2[j][0])
            g2[j][0] = this.compararletra(g1[i][0], g2[j][0]);
          if (g1[i][0] == g2[j][2])
            g2[j][2] = this.compararletra(g1[i][0], g2[j][2]);
          if (g1[i][2] == g2[j][0])
            g2[j][0] = this.compararletra(g1[i][2], g2[j][0]);
          if (g1[i][2] == g2[j][2])
            g2[j][2] = this.compararletra(g1[i][2], g2[j][2]);
        }
      return g2;
    },
    compararletra(palabra1, palabra2) {
      if (palabra1.length > 0 && palabra2.length > 0) {
        if (
          this.caractervalido(palabra1[0]) &&
          this.caractervalido(palabra2[0])
        ) {
          if (palabra1 == palabra2) {
            if (
              palabra2[0].charCodeAt() == 57 ||
              palabra2[0].charCodeAt() == 90 ||
              palabra2[0].charCodeAt() == 122
            ) {
              if (palabra2[0].charCodeAt() == 57) {
                palabra2 = palabra2.replace(
                  palabra2[0],
                  String.fromCharCode(palabra2[0].charCodeAt() + 8)
                );
              }
              if (palabra2[0].charCodeAt() == 90) {
                palabra2 = palabra2.replace(
                  palabra2[0],
                  String.fromCharCode(palabra2[0].charCodeAt() + 7)
                );
              }
              if (palabra2[0].charCodeAt() == 122) {
                palabra2 = palabra2.replace(
                  palabra2[0],
                  String.fromCharCode(palabra2[0].charCodeAt() - 74)
                );
              }
            } else
              palabra2 = palabra2.replace(
                palabra2[0],
                String.fromCharCode(palabra2[0].charCodeAt() + 1)
              );
          }
          return palabra2;
        }
      }
    },
    caractervalido(palabra) {
      for (let i = 0; i < palabra.length; i++) {
        if (
          palabra[i].charCodeAt() < 48 ||
          (palabra[i].charCodeAt() > 57 && palabra[i].charCodeAt() < 65) ||
          (palabra[i].charCodeAt() > 90 && palabra[i].charCodeAt() < 97) ||
          palabra[i].charCodeAt() > 122
        )
        return false;
      }
      return true;
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
          from: this.Buscar_id(this.ConjuntoQ3, element[0]),
          to: this.Buscar_id(this.ConjuntoQ3, element[4]),
          label: element[1] + "/" + element[2] + "/" + element[3],
        });
      });
      return object;
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
    Comparar(arr1, arr2) {
      for (let z = 0; z < arr1.length; z++) {
        if (arr1[z] == arr2[z]) return true;
      }
      return false;
    },
    graph() {
      console.log("graph()");
      //   this.node = new vis.DataSet(visestado(ConjuntoQ3));
      //   this.edge = new vis.DataSet(alfabetoxestado(Gama3));
      //   this.container = document.getElementById("mynetwork");
      //   this.data = { nodes: node, edges: edge };
      //   this.options = { edges: { arrows: { to: { enabled: true } } } };
      //   this.network = new vis.Network(container, data, options);
    },

    //Fin funciones visualizacion y creacion de automata

    // Funciones para simplificar afd

    final_nofinal(id, estadosf) {
      if (estadosf.includes(id))
        // true = final
        return true;
      //false = nofinal
      else return false;
    },
    CompararArray(arr1, arr2) {
      for (let i = 0; i < arr1.length; i++) {
        if (!arr2.includes(arr1[i])) return false;
      }
      return true;
    },
    añadirtransicion(estado_e, alfa, alfap1, alfap2, estado_s) {
      var conex = [];
      conex.push(estado_e);
      conex.push(alfa);
      conex.push(alfap1);
      conex.push(alfap2);
      conex.push(estado_s);
      return conex;
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
  },
};
</script>