import { onGlobalSetup, provide } from "@nuxtjs/composition-api";

export default () => {
  onGlobalSetup(() => {
    provide("globalKey", true);

    provide("appName", "Contacts App");
  });
};
