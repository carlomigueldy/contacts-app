<template>
  <div>
    <div class="text-center">
      <h1>Upload Spreadsheet</h1>

      <div>
        <v-icon
          @click="!state.isLoading$ ? $refs.fileInput.click() : null"
          style="cursor: pointer"
          color="green"
          size="256"
        >
          mdi-google-spreadsheet
        </v-icon>

        <!-- <img
                :src="state.imageSrc"
                class="image-header"
                alt="contact us image header"
                :style="{
                  width:
                    $vuetify.breakpoint.sm || $vuetify.breakpoint.xs
                      ? '100%'
                      : '70%'
                }"
              /> -->
      </div>

      <!-- Import Button -->
      <v-tooltip bottom>
        <template #activator="{on, attrs}">
          <v-btn
            v-on="on"
            v-bind="attrs"
            @click="$refs.fileInput.click()"
            :loading="state.isLoading$"
            x-large
            depressed
            color="primary"
          >
            Select a File
          </v-btn>
        </template>
        <span>File must be in CSV format</span>
      </v-tooltip>
    </div>

    <input
      ref="fileInput"
      type="file"
      @change="onChange($event)"
      style="display: none;"
      accept=".csv"
    />
  </div>
</template>

<script>
import { defineComponent, reactive, ref } from "@nuxtjs/composition-api";

export default defineComponent({
  setup() {
    const state = reactive({
      file: null,
      imageSrc: "svg/spreadsheet.svg",
      isLoading$: false,
      snackbarController: {
        success: false,
        fail: false
      }
    });

    return { state };
  },

  methods: {
    onChange(event) {
      this.state.file = event.target.files[0];

      if (!!this.state.file) this.uploadFile();

      console.log("[AppUploadSpreadsheetComponent] on change", this.state.file);
    },

    async uploadFile() {
      this.state.isLoading$ = true;

      const formData = new FormData();
      formData.append("file", this.state.file);

      try {
        const response = await this.$axios.post("/api/contacts", formData);

        console.log(
          "[AppUploadSpreadsheetComponent] uploadFile response",
          response
        );

        await this.$emit("uploaded", response);
      } catch (error) {
        console.log("[AppUploadSpreadsheetComponent] uploadFile error", error);
      } finally {
        this.state.isLoading$ = false;
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
