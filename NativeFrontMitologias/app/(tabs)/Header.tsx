import React from "react";
import { View, Text, StyleSheet, Dimensions } from 'react-native';

// Obtenemos las dimensiones de la pantalla
const { height } = Dimensions.get('window');

export default function Header() {
  return (
    <View style={styles.container}>
      <Text style={styles.title}>Mitologías HEADER</Text>
    </View>
  );
}
const styles = StyleSheet.create({
  container: {
    height: height * 0.15, // 15% del alto de la pantalla
    backgroundColor: '#432ab156', // color de ejemplo
    justifyContent: 'center',   // centra el texto arriba/abajo
    alignItems: 'center',       // centra el texto izquierda/derecha
  },
  title: {
    color: 'yellow',
    fontSize: 24,
    fontWeight: 'bold',
  },
});
