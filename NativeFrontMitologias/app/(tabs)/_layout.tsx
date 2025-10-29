import { Tabs } from "expo-router";

export default function TabsLayout() {
  return (
    <>
      <Tabs>
        <Tabs.Screen name="Login" options={{ title: "Login Page" }} />
        <Tabs.Screen name="index" options={{ title: "Home Page" }} />
      </Tabs>
    </>
  );
}
