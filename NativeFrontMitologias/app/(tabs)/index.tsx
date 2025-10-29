import { StyleSheet,Text, View } from "react-native";
import {Link} from "expo-router";

export default function Index() {
  return (
    <View
      style={styles.container}
    >
      <Text>Edit app/index.tsx to edit this screen.</Text>
      <Link href="/login">Go to Login page</Link>
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
