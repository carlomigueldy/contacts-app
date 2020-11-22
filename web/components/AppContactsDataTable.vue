<template>
  <div>
    <v-toolbar class="mb-10" flat color="transparent">
      <v-toolbar-title>
        <h2>Your contacts</h2>
      </v-toolbar-title>

      <v-spacer></v-spacer>

      <!-- Toggle Upload Spreadsheet Dialog Button -->
      <v-tooltip bottom>
        <template #activator="{on, attrs}">
          <v-btn
            @click="
              state.dialogController.uploadSpreadsheetDialog = !state
                .dialogController.uploadSpreadsheetDialog
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
    </v-toolbar>

    <v-data-table
      :search="state.search"
      :headers="state.headers"
      :items="items"
    ></v-data-table>

    <!-- Upload Spreadsheet Dialog -->
    <v-dialog
      v-model="state.dialogController.uploadSpreadsheetDialog"
      width="600"
    >
      <v-card class="pa-10" flat>
        <app-upload-spreadsheet
          @uploaded="onUploaded($event)"
        ></app-upload-spreadsheet>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import { defineComponent, reactive, ref } from "@nuxtjs/composition-api";

export default defineComponent({
  props: {
    items: {
      type: Array,
      required: true
    }
  },

  setup() {
    const state = reactive({
      search: "",
      items: [],
      headers: [
        {
          text: "ID",
          value: "id"
        },
        {
          text: "Team ID",
          value: "team_id"
        },
        {
          text: "Name",
          value: "name"
        },
        {
          text: "Phone",
          value: "phone"
        },
        {
          text: "Email",
          value: "email"
        },
        {
          text: "Date Created",
          value: "created_at"
        },
        {
          text: "Date Updated",
          value: "updated_at"
        }
      ],
      dialogController: {
        uploadSpreadsheetDialog: false
      }
    });

    return {
      state
    };
  },

  methods: {
    openUploadSpreadsheetDialog() {
      this.state.dialogController.uploadSpreadsheetDialog = true;
    },

    onUploaded(event) {
      this.state.dialogController.uploadSpreadsheetDialog = false;
      console.log("on uploaded", event);

      if (event.status === 200) {
        this.$emit("refetch", event);
      }
    }
  }
});
</script>
