import { Tabs } from "expo-router";
import FontAwesome from '@expo/vector-icons/FontAwesome';
import MaterialCommunityIcons from '@expo/vector-icons/MaterialCommunityIcons';
export default function TabsLayout() {
  return (
    <>
      <Tabs screenOptions={{tabBarActiveTintColor:"coral", tabBarActiveBackgroundColor:"#225a8fff",tabBarInactiveTintColor:"white", tabBarInactiveBackgroundColor:"#120b1fff"}}>
        <Tabs.Screen name="login" options={{ title: "Login Page" }} />
        <Tabs.Screen name="index" options={{ title: "Home Page",
        tabBarIcon:({color,focused})=>{
          return focused ? 
          (<MaterialCommunityIcons name="home-heart" size={24} color={color} />) : 
          (<FontAwesome name="home" size={24} color={color} />)
        },
         }} />
      </Tabs>
    </>
  );
}
