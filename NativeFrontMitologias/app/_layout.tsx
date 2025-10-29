import { Stack } from "expo-router";
import { Text } from "react-native";

export default function RootLayout() {
  return (
    <>
      <Text>este texto aparece en header</Text>
      <Stack>
        <Stack.Screen name="Login" options={{ title: "Login Page" }} />
        <Stack.Screen name="index" options={{ title: "Home Page" }} />
      </Stack>
      <Text>este texto aparece en footer</Text>
    </>
  );
}
