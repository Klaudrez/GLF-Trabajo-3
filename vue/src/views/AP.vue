<template>
  <div>
    <div v-if="grafo.nodos.length > 0">
      <Grafo :key="recargarGrafo" :grafo="grafo" />
    </div>
    <div v-if="alerta.estado">
      <v-alert text v-if="alerta.estado && alerta.tipo == 1" type="success">{{
        alerta.mensaje
      }}</v-alert>
      <v-alert text v-if="alerta.estado && alerta.tipo == 2" type="info">{{
        alerta.mensaje
      }}</v-alert>
      <v-alert text v-if="alerta.estado && alerta.tipo == 3" type="warning">{{
        alerta.mensaje
      }}</v-alert>
    </div>
    <h1 class="title">Datos autómatas</h1>
    <v-container fluid>
      <v-row>
        <v-col cols="2">
          <v-subheader>Conjunto de estados Q</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-combobox
            name="conjuntoQ"
            clearable
            outlined
            multiple
            v-model="opcionesNodos"
            :items="opcionesNodos"
            dense
            placeholder="q1,q2,q3,...,qn"
          ></v-combobox>
        </v-col>
        <v-col cols="4">
          <v-subheader>Ingrese cada estado y pulse 'enter'</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Alfabeto pila</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-combobox
            name="Alfabeto"
            clearable
            outlined
            multiple
            v-model="opcionesAlfabetoPila"
            :items="opcionesAlfabetoPila"
            dense
            placeholder="a,b,c,d,..."
          ></v-combobox>
        </v-col>
        <v-col cols="4">
          <v-subheader>Ingrese cada valor presionando 'enter'</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Alfabeto</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-combobox
            name="Alfabeto"
            clearable
            outlined
            multiple
            v-model="opcionesAlfabeto"
            :items="opcionesAlfabeto"
            dense
            placeholder="a,b,c,d,..."
          ></v-combobox>
        </v-col>
        <v-col cols="4">
          <v-subheader>Ingrese cada valor presionando 'enter'</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Estado inicial</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-select
            name="Inicial"
            :items="opcionesNodos"
            clearable
            no-data-text="Debe ingresar un conjunto de estados"
            outlined
            dense
            placeholder="q"
            v-model="Inicial"
          ></v-select>
        </v-col>
        <v-col cols="4">
          <v-subheader>Seleccione un estado</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Nueva transición</v-subheader>
        </v-col>
        <v-col cols="2">
          <v-select
            :items="opcionesNodos"
            clearable
            no-data-text="Debe ingresar un conjunto de estados"
            outlined
            dense
            placeholder="Origen"
            v-model="transicion.origen"
          ></v-select>
          <v-select
            :items="opcionesAlfabetoPila"
            clearable
            no-data-text="Debe ingresar alfabeto de la pila"
            outlined
            dense
            placeholder="Entrada pila"
            v-model="transicion.entradaPila"
          ></v-select>
        </v-col>
        <v-col cols="2">
          <v-select
            :items="opcionesAlfabeto"
            clearable
            no-data-text="Debe ingresar alfabeto"
            outlined
            dense
            placeholder="Alfabeto"
            v-model="transicion.alfabeto"
          ></v-select>
          <v-select
            :items="opcionesNodos"
            clearable
            no-data-text="Debe ingresar un conjunto de estados"
            outlined
            dense
            placeholder="Destino"
            v-model="transicion.destino"
          ></v-select>
        </v-col>
        <v-col cols="2">
          <v-select
            :items="opcionesAlfabetoPila"
            clearable
            no-data-text="Debe ingresar alfabeto de la pila"
            outlined
            dense
            placeholder="Salida pila"
            v-model="transicion.salidaPila"
          ></v-select>
          <v-btn
            color="primary"
            block
            depressed
            raised
            @click="this.agregarTransicion"
            >+ Transición</v-btn
          >
        </v-col>
        <v-col cols="4">
          <v-subheader>Agregar nueva transición</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Función de transición</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-select
            v-model="arregloGama"
            :items="arregloGama"
            chips
            no-data-text="Debe agregar transiciones"
            multiple
            outlined
            @change="changed()"
          >
            <template v-slot:selection="{ item }">
              <v-chip close @click:close="eliminarGama(item)">
                <strong>{{ item }}</strong>
              </v-chip>
            </template>
          </v-select>
        </v-col>
        <v-col cols="4">
          <v-subheader>Formato: q1,alfabeto/pila/pila,q2</v-subheader>
        </v-col>
      </v-row>

      <v-row>
        <v-col cols="2">
          <v-subheader>Estado(s) final(es)</v-subheader>
        </v-col>
        <v-col cols="6">
          <v-select
            name="Finales"
            :items="opcionesNodos"
            clearable
            no-data-text="Debe ingresar un conjunto de estados"
            multiple
            outlined
            dense
            placeholder="q1,q2,q3,q4"
            v-model="opcionFinales"
          ></v-select>
        </v-col>
        <v-col cols="4">
          <v-subheader>Seleccione uno o más estados</v-subheader>
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
          <v-select
            name="concatenarinicio"
            clearable
            :items="opciones"
            outlined
            dense
            placeholder="Inicio"
            v-model="Conca1"
          ></v-select>
        </v-col>
        <v-col cols="1">
          <v-subheader>Final</v-subheader>
        </v-col>
        <v-col cols="2">
          <v-select
            name="concatenarfinal"
            clearable
            :items="opciones"
            outlined
            dense
            placeholder="Final"
            v-model="Conca2"
          ></v-select>
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
      alerta: {
        estado: false,
        tipo: null,
        mensaje: null,
      },
      grafo: {
        nodos: [],
        alfabeto: [],
        inicial: [],
        aristas: [],
        finales: [],
      },
      transicion: {
        origen: null,
        entradaPila: null,
        alfabeto: null,
        salidaPila: null,
        destino: null,
      },
      arregloGama: [],
      opcionesNodos: [],
      opcionesAlfabetoPila: [],
      opcionesAlfabeto: [],
      opcionFinales: [],
      recargarGrafo: false,
      mostrar: false,
      Nodos: null,
      Alfabeto: null,
      Alfabetopila: null,
      Inicial: null,
      GamaF: null,
      Conca1: null,
      Conca2: null,
      opciones: ["1", "2"],
      Finales: null,
      E_inicial1: "",
      E_inicial2: "",
      E_inicialCombi: null,
      AlfabetoP1: [],
      AlfabetoP2: [],
      AlfabetoPCombi: [],
      ConjuntoQ1: [],
      ConjuntoQ2: [],
      ConjuntoPizarra: [],
      ConjuntoCombi: [],
      Alfabeto1: [],
      Alfabeto2: [],
      AlfabetoCombi: [],
      Gama1: [],
      Gama2: [],
      GamaPizarra: [],
      GamaCombi: [],
      E_Finales1: [],
      E_Finales2: [],
      E_FinalesCombi: [],
      node: null,
      edge: null,
      data: null,
      container: null,
      options: null,
      network: null,
    };
  },
  mounted() {
    this.$store.commit("writeLog", {
      level: "info",
      message: "Se accede a " + window.location.pathname + window.location.hash,
    });
  },
  watch: {
    arregloGama: function () {
      this.GamaF = this.arregloGama.join(";");
    },
    opcionesNodos: function () {
      this.Nodos = this.opcionesNodos.join(",");
    },
    opcionesAlfabetoPila: function () {
      this.Alfabetopila = this.opcionesAlfabetoPila.join(",");
    },
    opcionesAlfabeto: function () {
      this.Alfabeto = this.opcionesAlfabeto.join(",");
    },
    opcionFinales: function () {
      this.Finales = this.opcionFinales.join(",");
    },
  },
  methods: {
    eliminarGama(item) {
      this.arregloGama.splice(this.arregloGama.indexOf(item), 1);
    },
    crearAlerta(estado, tipo, mensaje) {
      this.alerta = {
        estado: estado,
        tipo: tipo,
        mensaje: mensaje,
      };
    },
    agregarTransicion() {
      if (this.transicion.origen != null && this.transicion.destino != null) {
        var nueva =
          this.transicion.origen +
          "," +
          (this.transicion.alfabeto ? this.transicion.alfabeto : "@") +
          "/" +
          (this.transicion.salidaPila ? this.transicion.salidaPila : "@") +
          "/" +
          (this.transicion.entradaPila ? this.transicion.entradaPila : "@") +
          "," +
          this.transicion.destino;
        if (this.arregloGama.indexOf(nueva) == -1) {
          this.arregloGama.push(nueva);
        }
        this.transicion = {
          origen: null,
          entradaPila: null,
          alfabeto: null,
          salidaPila: null,
          destino: null,
        };
      }
    },
    parsearGrafo(funcion) {
      if (
        (this.ConjuntoPizarra && this.Finales && this.GamaPizarra != null) ||
        funcion
      ) {
        var aristas = [];
        var nodosF = funcion ? this.E_FinalesCombi : this.Finales.split(",");
        if (this.grafo.finales.length > 0 && !funcion) {
          nodosF = nodosF.concat(this.grafo.finales);
        }
        if (funcion) {
          for (var i = 0; i < this.GamaCombi.length; i++) {
            var aristaC = this.GamaCombi[i];
            aristas.push({
              origen: aristaC[0],
              destino: aristaC[4],
              alfabeto: aristaC[1] + "/" + aristaC[2] + "/" + aristaC[3],
            });
          }
        } else {
          for (var j = 0; j < this.GamaPizarra.length; j++) {
            var arista = this.GamaPizarra[j];
            aristas.push({
              origen: arista[0],
              destino: arista[4],
              alfabeto: arista[1] + "/" + arista[2] + "/" + arista[3],
            });
          }
        }

        var inicial = this.grafo.inicial;
        if (inicial.indexOf(this.Inicial) == -1) {
          inicial.push(this.Inicial);
        }
        if (funcion) {
          inicial = [];
          inicial.push(this.E_inicialCombi);
        }
        if (this.ConjuntoPizarra.indexOf(inicial) == -1) {
          this.ConjuntoPizarra.push(inicial);
        }
        this.grafo = {
          nodos: funcion ? this.ConjuntoCombi : this.ConjuntoPizarra,
          inicial: inicial,
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
          this.AlfabetoP1,
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
      ) {
        this.$store.commit("writeLog", {
          level: "info",
          message: "Autómata 1: Hay uno o más campos sin definir",
        });
        this.crearAlerta(true, 3, "Hay campos en blanco");
      } else {
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
          this.AlfabetoP1 = this.Datos_dupli(P.split(","));
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
                this.AlfabetoP1,
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
              this.ConjuntoPizarra = this.copiararray(
                this.ConjuntoQ1,
                this.ConjuntoQ2
              );
              this.GamaPizarra = this.copiararray(this.Gama1, this.Gama2);

              this.mostrardatos(
                this.ConjuntoQ1,
                this.Alfabeto1,
                this.AlfabetoP1,
                this.Gama1,
                this.E_inicial1,
                this.E_Finales1,
                "A1"
              );
              this.$store.commit("writeLog", {
                level: "info",
                message: "Se ha ingresado el autómata 1 con éxito",
              });
              this.crearAlerta(
                true,
                1,
                "Se ha ingresado el autómata 1 con éxito. " +
                  /* this.strestados(this.ConjuntoQ1) +
                  this.strgama(this.Gama1) */
                  this.alertasAP(this.E_inicial1,
                                 this.E_Finales1,
                                 this.ConjuntoQ1,
                                 this.Gama1)
              );
              this.limpiarFormulario();
              // alert(
              //   this.strestados(this.ConjuntoQ1) + this.strgama(this.Gama1)
              // );
              this.parsearGrafo(false);
            } else {
              this.$store.commit("writeLog", {
                level: "info",
                message:
                  "Autómata 1: La función de transición contiene estados o alfabetos no declarados",
              });
              this.crearAlerta(
                true,
                3,
                "Datos no válidos. Deben estar contenidos en el alfabeto o en los estados."
              );
              this.E_inicial1 = this.ResetearAutomata(
                this.ConjuntoQ1,
                this.Alfabeto1,
                this.AlfabetoP1,
                this.Gama1,
                this.E_inicial1,
                this.E_Finales1
              );
            }
          } else {
            this.$store.commit("writeLog", {
              level: "info",
              message:
                "Autómata 1: El estado inicial no se encuentra en el conjunto de estados",
            });
            this.crearAlerta(
              true,
              3,
              "Datos no válidos. El estado inicial debe ser parte del conjunto de estados"
            );
            this.E_inicial1 = this.ResetearAutomata(
              this.ConjuntoQ1,
              this.Alfabeto1,
              this.AlfabetoP1,
              this.Gama1,
              this.E_inicial1,
              this.E_Finales1
            );
          }
        } else {
          this.$store.commit("writeLog", {
            level: "info",
            message: "Autómata 1: formato ingresado no válido",
          });
          this.crearAlerta(true, 3, "Formato ingresado no válido");
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
          this.AlfabetoP2,
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
      ) {
        this.$store.commit("writeLog", {
          level: "info",
          message: "Autómata 2: Hay uno o más campos sin definir",
        });
        this.crearAlerta(true, 3, "Hay campos en blanco");
      } else {
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
          this.AlfabetoP2 = this.Datos_dupli(P.split(","));
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
                this.AlfabetoP2,
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
              this.ConjuntoPizarra = this.copiararray(
                this.ConjuntoQ1,
                this.ConjuntoQ2
              );
              this.GamaPizarra = this.copiararray(this.Gama1, this.Gama2);
              this.mostrardatos(
                this.ConjuntoQ2,
                this.Alfabeto2,
                this.AlfabetoP2,
                this.Gama2,
                this.E_inicial2,
                this.E_Finales2,
                "A2"
              );
              this.$store.commit("writeLog", {
                level: "info",
                message: "Se ha ingresado el autómata 2 con éxito",
              });
              this.crearAlerta(
                true,
                1,
                "Se ha ingresado el autómata 2 con éxito. " +
                  /* this.strestados(this.ConjuntoQ2) +
                  this.strgama(this.Gama2) */
                  this.alertasAP(this.E_inicial2,
                                 this.E_Finales2,
                                 this.ConjuntoQ2,
                                 this.Gama2)
              );
              this.limpiarFormulario();
              // alert(
              //   this.strestados(this.ConjuntoQ2) + this.strgama(this.Gama2)
              // );
              this.parsearGrafo(false);
            } else {
              this.$store.commit("writeLog", {
                level: "info",
                message:
                  "Autómata 2: La función de transición contiene estados o alfabetos no declarados",
              });
              this.crearAlerta(
                true,
                3,
                "Datos no válidos. Deben ser parte del alfabeto o del conjunto de estados"
              );
              this.E_inicial2 = this.ResetearAutomata(
                this.ConjuntoQ2,
                this.Alfabeto2,
                this.AlfabetoP2,
                this.Gama2,
                this.E_inicial2,
                this.E_Finales2
              );
            }
          } else {
            this.$store.commit("writeLog", {
              level: "info",
              message:
                "Autómata 2: El estado inicial no se encuentra en el conjunto de estados",
            });
            this.crearAlerta(
              true,
              3,
              "Datos no válidos. El estado inicial debe ser parte del conjunto de estados"
            );
            this.E_inicial2 = this.ResetearAutomata(
              this.ConjuntoQ2,
              this.Alfabeto2,
              this.AlfabetoP2,
              this.Gama2,
              this.E_inicial2,
              this.E_Finales2
            );
          }
        } else {
          this.$store.commit("writeLog", {
            level: "info",
            message: "Autómata 2: formato ingresado no válido",
          });
          this.crearAlerta(true, 3, "Formato ingresado no válido");
        }
      }
    },
    limpiarFormulario() {
      this.transicion = {
        origen: null,
        entradaPila: null,
        alfabeto: null,
        salidaPila: null,
        destino: null,
      };
      this.arregloGama = [];
      this.opcionesNodos = [];
      this.opcionesAlfabetoPila = [];
      this.opcionesAlfabeto = [];
      this.opcionFinales = [];
      // this.Nodos = null;
      // this.Alfabeto = null;
      // this.Inicial = null;
      // this.GamaF = null;
      // this.Finales = null;
    },
    reset() {
      this.limpiar();
      console.log("Datos borrados.");
      this.limpiarFormulario();
      this.E_inicial1 = this.ResetearAutomata(
        this.ConjuntoQ1,
        this.Alfabeto1,
        this.AlfabetoP1,
        this.Gama1,
        this.E_inicial1,
        this.E_Finales1
      );

      this.E_inicial2 = this.ResetearAutomata(
        this.ConjuntoQ2,
        this.Alfabeto2,
        this.AlfabetoP2,
        this.Gama2,
        this.E_inicial2,
        this.E_Finales2
      );

      this.E_inicialCombi = this.ResetearAutomata(
        this.ConjuntoCombi,
        this.AlfabetoCombi,
        this.AlfabetoPCombi,
        this.GamaCombi,
        this.E_inicialCombi,
        this.E_FinalesCombi
      );

      this.ConjuntoPizarra = this.copiararray(this.ConjuntoQ1, this.ConjuntoQ2);
      this.GamaPizarra = this.copiararray(this.Gama1, this.Gama2);
      this.parsearGrafo(false);
    },
    ResetearAutomata(
      estados,
      alfabeto,
      alfabetopila,
      gama,
      e_inicial,
      e_finales
    ) {
      estados =[];
      alfabeto = [];
      alfabetopila = [];
      gama = [];
      e_inicial = null;
      e_finales = [];
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
      // console.clear();
    },
    mostrardatos(
      conjunto,
      alfabeto,
      alfabetopila,
      gama,
      e_ini,
      e_final,
      Nautomata
    ) {
      console.log("Estados " + Nautomata + ":", conjunto);
      console.log("Alfabeto Pila " + Nautomata + ":", alfabetopila);
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
            this.AlfabetoP1,
            this.Gama1,
            this.E_inicial1,
            this.E_Finales1,
            "A1"
          );
          this.mostrardatos(
            this.ConjuntoQ2,
            this.Alfabeto2,
            this.AlfabetoP2,
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
          this.ConjuntoPizarra = this.copiararray(this.ConjuntoCombi, []);
          this.GamaPizarra = this.copiararray(this.GamaCombi, []);
          this.mostrardatos(
            this.ConjuntoCombi,
            this.Alfabeto1,
            this.AlfabetoP1,
            this.GamaCombi,
            this.E_inicialCombi,
            this.E_FinalesCombi,
            "Au"
          );
          this.$store.commit("writeLog", {
            level: "info",
            message:
              "Unión: " +
              /* this.strestados(this.ConjuntoCombi) +
              this.strgama(this.GamaCombi) */
              this.alertasAP(this.E_inicialCombi,
                             this.E_FinalesCombi,
                             this.ConjuntoCombi,
                             this.GamaCombi),
              
          });
          this.crearAlerta(
            true,
            1,
            "Se han unido los automatas. " +
              /* this.strestados(this.ConjuntoCombi) +
              this.strgama(this.GamaCombi) */
              this.alertasAP(this.E_inicialCombi,
                             this.E_FinalesCombi,
                             this.ConjuntoCombi,
                             this.GamaCombi),
          );
          this.parsearGrafo(true);
        } else {
          this.$store.commit("writeLog", {
            level: "info",
            message:
              "Falló unión: Los autómatas no tienen coincidencias en sus alfabetos",
          });
          this.crearAlerta(
            true,
            3,
            "Los autómatas no tienen coincidencias en sus alfabetos"
          );
        }
      } else {
        this.$store.commit("writeLog", {
          level: "info",
          message: "Fallo unión: debe ingresar ambos autómatas",
        });
        this.crearAlerta(true, 3, "Debe ingresar ambos autómatas");
      }
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
                  this.AlfabetoP1,
                  this.Gama1,
                  this.E_inicial1,
                  this.E_Finales1,
                  "A1"
                );
                this.mostrardatos(
                  this.ConjuntoQ2,
                  this.Alfabeto2,
                  this.AlfabetoP2,
                  this.Gama2,
                  this.E_inicial2,
                  this.E_Finales2,
                  "A2"
                );

                this.ConjuntoQ1.splice(0, 0, "Ni");
                this.ConjuntoQ1.push("Nf");

                this.ConjuntoCombi = this.Datos_dupli(
                  this.copiararray(this.ConjuntoQ1, this.ConjuntoQ2)
                );
                this.GamaCombi = this.copiararray(this.Gama1, this.Gama2);
                this.AlfabetoCombi = this.Datos_dupli(
                  this.copiararray(this.Alfabeto1, this.Alfabeto2)
                );
                this.AlfabetoPCombi = this.Datos_dupli(
                  this.copiararray(this.AlfabetoP1, this.AlfabetoP2)
                );
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

                this.ConjuntoPizarra = this.copiararray(this.ConjuntoCombi, []);
                this.GamaPizarra = this.copiararray(this.GamaCombi, []);

                this.mostrardatos(
                  this.ConjuntoCombi,
                  this.AlfabetoCombi,
                  this.AlfabetoPCombi,
                  this.GamaCombi,
                  this.E_inicialCombi,
                  this.E_FinalesCombi,
                  "Ac"
                );
                this.$store.commit("writeLog", {
                  level: "info",
                  message:
                    "Concatenación: " +
                    this.strestados(this.ConjuntoCombi) +
                    this.strgama(this.GamaCombi),
                });
                this.crearAlerta(
                  true,
                  1,
                  "Se han concatenado los autómatas. " +
                    this.strestados(this.ConjuntoCombi) +
                    this.strgama(this.GamaCombi)
                );
                this.parsearGrafo(true);
              } else {
                this.mostrardatos(
                  this.ConjuntoQ2,
                  this.Alfabeto2,
                  this.AlfabetoP2,
                  this.Gama2,
                  this.E_inicial2,
                  this.E_Finales2,
                  "A2"
                );
                this.mostrardatos(
                  this.ConjuntoQ1,
                  this.Alfabeto1,
                  this.AlfabetoP1,
                  this.Gama1,
                  this.E_inicial1,
                  this.E_Finales1,
                  "A1"
                );

                this.ConjuntoQ2.splice(0, 0, "Ni");
                this.ConjuntoQ2.push("Nf");

                this.ConjuntoCombi = this.Datos_dupli(
                  this.copiararray(this.ConjuntoQ2, this.ConjuntoQ1)
                );
                this.GamaCombi = this.copiararray(this.Gama2, this.Gama1);
                this.AlfabetoCombi = this.Datos_dupli(
                  this.copiararray(this.Alfabeto2, this.Alfabeto1)
                );
                this.AlfabetoPCombi = this.Datos_dupli(
                  this.copiararray(this.AlfabetoP2, this.AlfabetoP1)
                );
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

                this.ConjuntoPizarra = this.copiararray(this.ConjuntoCombi, []);
                this.GamaPizarra = this.copiararray(this.GamaCombi, []);

                this.mostrardatos(
                  this.ConjuntoCombi,
                  this.AlfabetoCombi,
                  this.AlfabetoPCombi,
                  this.GamaCombi,
                  this.E_inicialCombi,
                  this.E_FinalesCombi,
                  "Ac"
                );
                this.parsearGrafo(true);
                this.$store.commit("writeLog", {
                  level: "info",
                  message:
                    "Concatenación: " +
                    this.strestados(this.ConjuntoCombi) +
                    this.strgama(this.GamaCombi),
                });
                this.crearAlerta(
                  true,
                  1,
                  "Se han concatenado los autómatas. " +
                    this.strestados(this.ConjuntoCombi) +
                    this.strgama(this.GamaCombi)
                );
              }
            } else {
              this.$store.commit("writeLog", {
                level: "info",
                message:
                  "Fallo concatenación: autómatas ingresados no coinciden o están duplicados",
              });
              this.crearAlerta(
                true,
                3,
                "Los autómatas ingresados no coinciden con [1,2] o ingresó el mismo autómata dos veces"
              );
            }
          } else {
            this.$store.commit("writeLog", {
              level: "info",
              message:
                "Fallo concatenación: no deben quedar en blanco los campos",
            });
            this.crearAlerta(
              true,
              3,
              "No deben quedar en blanco los campos de concatenacion"
            );
          }
        } else {
          this.$store.commit("writeLog", {
            level: "info",
            message:
              "Fallo concatenación: autómatas no comparten concordancia en sus alfabetos",
          });
          this.crearAlerta(
            true,
            3,
            "No comparten concordancias en sus alfabetos"
          );
        }
      } else {
        this.$store.commit("writeLog", {
          level: "info",
          message: "Fallo concatenación: debe ingresar ambos autómatas",
        });
        this.crearAlerta(true, 3, "Debe ingresar ambos automatas");
      }
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
            } else {
              aux = aux.replace(
                aux[0],
                String.fromCharCode(aux[0].charCodeAt() + 1)
              );
            }
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
            } else {
              palabra2 = palabra2.replace(
                palabra2[0],
                String.fromCharCode(palabra2[0].charCodeAt() + 1)
              );
            }
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
          from: this.Buscar_id(this.ConjuntoPizarra, element[0]),
          to: this.Buscar_id(this.ConjuntoPizarra, element[4]),
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
    strgama(gama) {
      var str = "Transicion(es) :    \n";
      for (let i = 0; i < gama.length; i++)
        str =
          str +
          gama[i][0] +
          " - " +
          gama[i][1] +
          "/" +
          gama[i][2] +
          "/" +
          gama[i][3] +
          " - " +
          gama[i][4] +
          "\n";
      return str;
    },
    strfinales(gama)
    {
        var str="Estado(s) final(es) : \n";
        for(let i=0;i<gama.length;i++){
          if(i!=gama.length-1){
            str = str + gama[i] + " - ";
          }
          else{
            str = str + gama[i] + "      \n";
          }
        }
          
        return str
    },
    
    
    strestados(estados) {
      var str = "Estado(s) :  \n";
      for (let i = 0; i < estados.length; i++) {
        if (i != estados.length - 1) {
          str = str + estados[i] + " - ";
        } else str = str + estados[i] + "     \n";
      }
      return str;
    },
    alertasAP(E_inicial,E_Finales,Conjunto,Gama){
      return "Estado inicial : \n" +
      E_inicial + "     \n" + 
      this.strfinales(E_Finales) + 
      this.strestados(Conjunto) + 
      this.strgama(Gama);
    },
  },
};
</script>