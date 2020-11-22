<template>
  <v-main>
    <v-container class="fill-height">
      <v-row justify="center" align="center">
        <v-col lg="8" md="10" sm="12" xs="12">
          <div v-show="!state.isLoading" class="text-center">
            <app-contacts-data-table
              ref="appContactsDataTableComponent"
              v-show="state.hasContacts"
              :items="state.contacts"
            ></app-contacts-data-table>
            <div v-show="!state.hasContacts">
              <div>
                <img
                  :src="state.noContactsImgSrc"
                  class="image-header"
                  alt="contact us image header"
                  :style="{
                    width:
                      $vuetify.breakpoint.sm || $vuetify.breakpoint.xs
                        ? '100%'
                        : '70%'
                  }"
                />
              </div>

              <div class="headline mb-5">It appears that you don't have any contacts yet.</div>

              <!-- Toggle Upload Spreadsheet Dialog Button -->
              <v-tooltip bottom>
                <template #activator="{on, attrs}">
                  <v-btn
                    @click="
                      $refs.appContactsDataTableComponent.openUploadSpreadsheetDialog()
                    "
                    v-on="on"
                    v-bind="attrs"
                    color="primary"
                    depressed
                    x-large
                  >
                    Import
                  </v-btn>
                </template>
                <span>Select to import contacts</span>
              </v-tooltip>
            </div>
          </div>
          <div v-show="state.isLoading" class="text-center">
            <v-progress-circular
              indeterminate
              color="primary"
              class="mb-10"
            ></v-progress-circular>
            <div>Fetching contacts, please wait ...</div>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </v-main>
</template>

<script>
import {
  computed,
  defineComponent,
  provide,
  reactive,
  ref,
  useContext,
  useFetch
} from "@nuxtjs/composition-api";
import axios from "axios";
import { Contact } from "../models/Contact";
import { API_BASE_URL } from "../nuxt.config";

export default defineComponent({
  created() {
    this.fetchAllContacts();
  },

  setup() {
    const state = reactive({
      contacts: [],
      isLoading: false,
      noContactsImgSrc: "svg/contact-us.svg",
      hasContacts: computed(() => state.contacts.length > 0)
    });

    return {
      state
    };
  },

  methods: {
    async fetchAllContacts() {
      console.log("[IndexPage] fetchAllContacts called");
      this.state.isLoading = true;

      try {
        const response = await this.$axios.$get("api/contacts");
        this.state.contacts = response.data;
        console.log("[IndexPage] fetchAllContacts response", response);
      } catch (error) {
        console.log("[IndexPage] on error", error);
      } finally {
        this.state.isLoading = false;
        // this.state.contacts = [
        //   {
        //     id: null,
        //     team_id: null,
        //     name: null,
        //     phone: null,
        //     email: null,
        //     sticky_phone_number_id: null,
        //     created_at: null,
        //     updated_at: null
        //   }
        // ];
      }
    }
  }
});
</script>

<style scoped>
.image-header {
  height: 450px;
}
</style>
