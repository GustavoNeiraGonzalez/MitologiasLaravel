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

    useEffect(() => {
    axios
      .get("http://127.0.0.1:8000/api/mitologias")
      .then((response) => {
        // Asumiendo que la API devuelve { Mitologias: [...] }
        setMitologias(response.data.Mitologias);
      })
      .catch((err) => {
        console.log("Error al obtener mitologías:", err);
      });
  }, []);


  return (
   <View style={styles.container}>
      <Text>Mitologías disponibles:</Text>

      {mitologias.map((item) => (
        <Text key={item.id}>📘 {item.titulo}</Text>
      ))}

      <Link href="/login">Ir a Login</Link>
    </View>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: "#3e08a1ff",
    alignItems: "center",
    justifyContent: "center",
  },
});
