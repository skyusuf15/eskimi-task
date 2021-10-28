<template>
  <div>
    <title-bar :title-stack="titleStack" />
    <hero-bar>
      {{ heroTitle }}
      <router-link slot="right" to="/adverts/index" class="button">
        Advertisements
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <tiles>
        <card-component
          :title="formCardTitle"
          icon="account-edit"
          class="tile is-child"
        >
          <form @submit.prevent="submit">
            <b-field label="Name" message="Advertisement name" horizontal>
              <b-input
                placeholder="e.g. 9Mobile Ads"
                v-model="form.name"
                required
              />
            </b-field>

            <hr />
            <b-field label="From" message="From" horizontal>
              <b-datepicker
                v-model="form.from"
                placeholder="Click to select..."
                icon="calendar-today"
              >
              </b-datepicker>
              <b-input
                placeholder="e.g 2021-11-01"
                v-model="form.from"
                required
              />
            </b-field>
            <b-field label="To" message="to" horizontal>
              <b-datepicker
                v-model="form.to"
                placeholder="Click to select..."
                icon="calendar-today"
              >
              </b-datepicker>
              <b-input
                placeholder="e.g 2021-11-01"
                v-model="form.to"
                required
              />
            </b-field>
            <hr />

            <b-field label="Total Budget ($)" message="Total Budget" horizontal>
              <b-numberinput
                step='0.01' value='0.00' placeholder='0.00'
                v-model="form.total_budget"
                required
              />
            </b-field>
            <b-field label="Daily Budget ($)" message="Daily Budget" horizontal>
              <b-numberinput
                step='0.01' value='0.00' placeholder='0.00'
                v-model="form.daily_budget"
                required
              />
            </b-field>
            <hr />
            <b-field label="Banners" horizontal>
              <input
                type="file"
                name="banners"
                class="d-none"
                id="vue-file-upload-input"
                accept="image/*"
                multiple="true"
                @change="onFileChange"
              />
            </b-field>
            <hr />
            <b-field horizontal>
              <div v-for="(image, key) in images" :key="key">
                <div>
                  <img class="preview" :ref="'image'" />
                  {{ image.name }}
                </div>
              </div>
            </b-field>

            <hr />

            <b-field horizontal>
              <b-button
                type="is-primary"
                :loading="isLoading"
                native-type="submit"
                >Submit</b-button
              >
            </b-field>
          </form>
        </card-component>
      </tiles>
    </section>
  </div>
</template>

<script>
import clone from "lodash/clone";
import moment from "moment";
import TitleBar from "@/components/TitleBar";
import HeroBar from "@/components/HeroBar";
import Tiles from "@/components/Tiles";
import CardComponent from "@/components/CardComponent";
import Notification from "@/components/Notification";

export default {
  name: "AdvertForm",
  components: {
    CardComponent,
    Tiles,
    HeroBar,
    TitleBar,
    Notification,
  },
  props: {
    id: {
      default: null,
    },
    itemData: {
      default: null,
    },
  },
  data() {
    return {
      isLoading: false,
      item: null,
      form: this.getClearFormObject(),
      images: [],
    };
  },
  computed: {
    heroTitle() {
      if (!!this.item) {
        return this.form.name;
      } else {
        return "Create Advert";
      }
    },
    titleStack() {
      let lastCrumb;

      if (this.isProfileExists) {
        lastCrumb = this.form.name;
      } else {
        lastCrumb = "New Advert";
      }
      return ["Admin", "Advertisement", lastCrumb];
    },
    formCardTitle() {
      if (this.isProfileExists) {
        return "Edit Advert";
      } else {
        return "New Advert";
      }
    },
  },
  created() {
    this.getData();
  },
  methods: {
    getClearFormObject() {
      return {
        id: null,
        name: null,
        from: new Date(),
        to: new Date(),
        total_budget: null,
        daily_budget: null,
      };
    },
    getData() {
      if (this.itemData) {
        this.form = this.itemData;
        this.item = clone(this.itemData);
        this.form.from = new Date(this.itemData.from);
        this.form.to = new Date(this.itemData.to);
        this.form.banner_image_path = JSON.parse(
          this.itemData.banner_image_path
        );
      }
    },
    onFileChange(e) {
      this.images = [];
      this.form.attachments = e.target.files;
      var selectedFiles = this.form.attachments;
      for (let i = 0; i < selectedFiles.length; i++) {
        this.images.push(selectedFiles[i]);
      }

      for (let i = 0; i < this.images.length; i++) {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.$refs.image[i].src = reader.result;
        };

        reader.readAsDataURL(this.images[i]);
      }
    },
    submit() {
      this.isLoading = true;

      let formData = new FormData();
      if (this.form.attachments && this.form.attachments.length > 0) {
        for (var i = 0; i < this.form.attachments.length; i++) {
          let attachment = this.form.attachments[i];
          formData.append("banners[]", attachment);
        }
      }
      if (!this.id) {
        delete this.form.id;
      }

      Object.keys(this.form).map(
        (key) => key != "attachments" && formData.append(key, this.form[key])
      );
      formData.append("user_id", this.$store.state.userId);
      formData.set(
        "from",
        moment(this.form.from).format("YYYY-MM-DD").toString()
      );
      formData.set("to", moment(this.form.to).format("YYYY-MM-DD").toString());

      formData.delete("banner_image_path");
      formData.delete("created_at");
      formData.delete("updated_at");

      let method = "post";
      let url = "/api/advertisements";

      axios({
        method,
        url,
        data: formData,
        headers: {
          "Content-Type": "multipart/form-data",
        },
      })
        .then((r) => {
          this.isLoading = false;

          this.$router.push({
            name: "adverts.index",
          });

          if (!this.id && r.data.data.id) {
            this.$buefy.snackbar.open({
              message: "Advert Created Successfully",
              queue: false,
            });
          } else {
            this.$buefy.snackbar.open({
              message: r.data?.data?.message,
              queue: false,
            });
          }
        })
        .catch((e) => {
          this.isLoading = false;

          this.$buefy.toast.open({
            message: `Error: ${e.data}`,
            type: "is-danger",
            queue: false,
          });
        });
    },
  },
  watch: {
    id(newValue) {
      this.form = this.getClearFormObject();
      this.item = null;

      if (newValue) {
        this.getData();
      }
    },
    itemData() {},
  },
};
</script>
