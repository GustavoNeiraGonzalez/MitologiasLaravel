import React from 'react';
import { View, Text, Image, StyleSheet, Pressable } from 'react-native';

export default function Historia() {
  return (
    <View style={styles.card}>
      <Image
        source={{ uri: 'https://via.placeholder.com/150' }}
        style={styles.image}
      />
      <View style={styles.body}>
        <Text style={styles.title}>Card title</Text>
        <Text style={styles.text}>
          Some quick example text to build on the card title and make up the bulk of the card’s content.
        </Text>
        <Pressable style={styles.button} onPress={() => console.log('Go somewhere')}>
          <Text style={styles.buttonText}>Go somewhere</Text>
        </Pressable>
      </View>
    </View>
  );
}
const styles = StyleSheet.create({
  card: {
    borderWidth: 1,
    borderColor: '#ccc',
    borderRadius: 8,
    overflow: 'hidden',
    margin: 16,
    backgroundColor: '#fff',
  },
  image: {
    width: '100%',
    height: 150,
  },
  body: {
    padding: 16,
  },
  title: {
    fontSize: 18,
    fontWeight: 'bold',
    marginBottom: 8,
  },
  text: {
    fontSize: 14,
    marginBottom: 12,
  },
  button: {
    backgroundColor: '#007bff',
    paddingVertical: 10,
    paddingHorizontal: 12,
    borderRadius: 4,
    alignItems: 'center',
  },
  buttonText: {
    color: '#fff',
    fontWeight: 'bold',
  },
});
