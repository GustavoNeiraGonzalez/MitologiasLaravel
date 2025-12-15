import { StyleSheet,Text, View } from "react-native";
import {Link} from "expo-router";
import { useEffect, useState } from "react";
import axios from "axios";
interface Mitologia {
  id: number;
  titulo: string;
}
export default function Index() {
  const [mitologias, setMitologias] = useState<Mitologia[]>([]);
  const mitologiasurl = "http://192.168.18.220:8000/api/mitologias"; 

    useEffect(() => {
    axios
      .get(mitologiasurl)
      .then((response) => {
        // Asumiendo que la API devuelve { Mitologias: [...] }
        setMitologias(response.data.Mitologias);
      })
      .catch((err) => {
        console.log("Error al obtener mitologías:", err);
      });
  }, []);
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
  <View style={styles.container}>
    <Text style={styles.title}>Mitologías disponibles</Text>

    <View style={styles.grid}>
      {mitologias.map((item) => (
        <View key={item.id} style={styles.card}>
          <Text style={styles.cardText}>{item.titulo}</Text>
        </View>
      ))}
    </View>

    <Link href="/login">Ir a Login</Link>
  </View>
  );
}