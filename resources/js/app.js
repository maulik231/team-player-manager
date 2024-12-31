import { createApp } from "vue";
import TeamPlayerBuilder from "./components/TeamPlayerBuilder.vue";

const app = createApp({});
app.component("team-player-builder", TeamPlayerBuilder);
app.mount("#app");
