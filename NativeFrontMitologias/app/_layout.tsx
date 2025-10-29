import { Stack } from "expo-router";
import { Text } from "react-native";

export default function RootLayout() {
  return (
    <>
      <Text>este texto aparece en header</Text>
      <Stack />
      <Text>este texto aparece en footer</Text>
    </>
  );
}
