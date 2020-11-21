<template>
  <v-main>
    <v-container class="fill-height">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="12" xs="12">
          <app-contacts-data-table></app-contacts-data-table>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import { defineComponent, reactive, ref } from "@nuxtjs/composition-api";

export default defineComponent({
  setup() {}
});
</script>
