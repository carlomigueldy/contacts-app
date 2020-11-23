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
              @refetch="fetchAllContacts()"
              @uploaded="onUploaded($event)"
              @uploaded-error="onUploadedError($event)"
            ></app-contacts-data-table>
            <div v-show="!state.hasContacts">
              <div>
                <img
                  :src="state.noContactsImgSrc"
                  class="image-header"
                  alt="contact us image header"
                  :style="{
                    width: state.isSmallScreen ? '100%' : '70%'
                  }"
                />
              </div>

              <div class="headline mb-5">
                It appears that you don't have any contacts yet.
              </div>

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

    <v-snackbar v-model="snackBarController.show">
      {{ snackBarController.message }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="pink"
          text
          v-bind="attrs"
          @click="snackBarController.show = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
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
  setup() {
    const context = useContext();
    const state = reactive({
      contacts: [],
      isLoading: false,
      noContactsImgSrc: "svg/contact-us.svg",
      hasContacts: computed(() => state.contacts.length > 0),
      breakpoint: computed(() => context.$vuetify.breakpoint),
      isSmallScreen: computed(() => state.breakpoint.sm || state.breakpoint.xs)
    });
    const snackBarController = reactive({
      message: "",
      show: false
    });

    const onUploaded = event => {
      if (event.status === 200) {
        showSnackbar({ message: event.data.message });
      }
    };

    const onUploadedError = event => {
      console.log("on uploaded error", event);
      if (event.status === 422) {
        showSnackbar({
          message:
            "The CSV file you are trying to uploaded is not a compatible format."
        });
      }
    };

    const showSnackbar = ({ message }) => {
      snackBarController.message = message;
      snackBarController.show = true;
    };

    const fetchAllContacts = async () => {
      console.log("[IndexPage] fetchAllContacts called");
      state.isLoading = true;

      try {
        const response = await context.$axios.$get("api/contacts");
        state.contacts = response.data;
        console.log("[IndexPage] fetchAllContacts response", response);
      } catch (error) {
        console.log("[IndexPage] on error", error);
      } finally {
        state.isLoading = false;
      }
    };

    fetchAllContacts();

    return {
      state,
      snackBarController,
      onUploaded,
      onUploadedError,
      showSnackbar,
      fetchAllContacts
    };
  }
});
</script>

<style scoped>
.image-header {
  height: 450px;
}
</style>
