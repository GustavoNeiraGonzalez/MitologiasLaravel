import { StyleSheet,View, Text } from "react-native";
import {useLocalSearchParams , Link, Stack} from "expo-router";
import { useEffect, useState } from "react";
import axios from "axios";
interface Mitologia {
  id: number;
  titulo: string;
}

export default function MitologiaTitulo() {
  //aqui obtendremos el titulo de la mitologia o historia, correspondiente a la civilizacion seleccionada previamente
  const [mitologias, setMitologias] = useState<Mitologia[]>([]);
  const [civilizacion, setCivilizacion] = useState<string>("");
  const { id } = useLocalSearchParams(); // Obtener el ID de la civilización desde los parámetros de búsqueda
  const mitologiasUrl = `http://192.168.18.42:8000/api/civilizaciones/${id}`;

  useEffect(() => {
    axios
      .get(mitologiasUrl)
      .then((response) => {
          console.log(response.data);
        setMitologias(response.data.mitologias); // Asegúrate de que la respuesta tenga la estructura correcta para acceder a las mitologías
        setCivilizacion(response.data.civilizacion); // Establecer el nombre de la civilización
      })
      .catch((err) => {
        console.log("Error al obtener Titulo de la historia:", err);
      });
  }, [mitologiasUrl]); // Agregar mitologiasUrl como dependencia para que se ejecute cuando cambie el ID de civilización

  const styles = StyleSheet.create({

    container: {
      flex: 1,
      padding: 16,
      backgroundColor: "#3e08a1ff",

    },

    title: {
      fontSize: 20,
      fontWeight: "bold",
      marginBottom: 16,
      textAlign: "center",
    },

    grid: {
      flexDirection: "row",
      flexWrap: "wrap",
    },

    card: {
      width: "50%",          // 👈 mitad del ancho
      padding: 8,
    },

    cardText: {
      backgroundColor: "#f2f2f2",
      padding: 16,
      borderRadius: 10,
      textAlign: "center",
      fontWeight: "600",
    },
  });



  return (
     <>
      <Stack.Screen options={{ title: civilizacion }} />
      <View>
        {mitologias.map((item, index) => (
          <Link key={index} href={`./mitologia/${item.id}`}>
            <View style={styles.card}>
              <Text style={styles.cardText}>{item.titulo}</Text>
            </View>
          </Link>
        ))}
        <Text>HOLA MUNDO</Text>
      </View>
     </>
  );
}