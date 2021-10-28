<template>
  <div>
    <title-bar :title-stack="['Admin', 'Advertisement']" />
    <hero-bar>
      Advertisements
      <router-link to="/adverts/" class="button" slot="right">
        Add Advertisement Campaign
      </router-link>
    </hero-bar>
    <section class="section is-main-section">
      <div v-if="isGallery">
        <p>Click to preview image</p>
        <silent-box :gallery="gallery"></silent-box>
      </div>

      <card-component
        class="has-table has-mobile-sort-spaced"
        title="Advertisements"
        icon="account-multiple"
      >
        <b-table
          :checked-rows.sync="checkedRows"
          :checkable="false"
          :loading="isLoading"
          :paginated="paginated"
          :per-page="perPage"
          :striped="true"
          :hoverable="true"
          default-sort="name"
          :data="adverts"
        >
          <b-table-column
            class="has-no-head-mobile is-image-cell"
            v-slot="props"
          >
            <div v-if="props.row.avatar" class="image">
              <img :src="props.row.avatar" class="is-rounded" />
            </div>
          </b-table-column>
          <b-table-column label="Name" field="name" sortable v-slot="props">
            {{ props.row.name }}
          </b-table-column>
          <b-table-column label="From" field="from" sortable v-slot="props">
            {{ props.row.from }}
          </b-table-column>
          <b-table-column label="To" field="to" sortable v-slot="props">
            {{ props.row.to }}
          </b-table-column>

          <b-table-column
            label="Total Budget ($)"
            field="total_budget"
            sortable
            v-slot="props"
          >
            {{ props.row.total_budget }}
          </b-table-column>

          <b-table-column
            label="Daily Budget ($)"
            field="daily_budget"
            sortable
            v-slot="props"
          >
            {{ props.row.daily_budget }}
          </b-table-column>

          <b-table-column
            custom-key="actions"
            class="is-actions-cell"
            v-slot="props"
          >
            <div class="buttons is-right">
              <router-link
                :to="{
                  name: 'adverts.edit',
                  params: { id: props.row.id, itemData: props.row },
                }"
                class="button is-small is-primary"
              >
                <!-- <b-icon icon="account-edit" size="is-small" /> -->
                Edit
              </router-link>
              <button
                class="button is-small"
                type="button"
                @click.prevent="previewImage(props.row)"
              >
                <span>View Banners</span>
              </button>

              <button
                class="button is-small is-info"
                type="button"
                @click.prevent="viewAdvert(props.row)"
              >
                <span>View Info</span>

                <!-- <b-icon icon="eye-view" size="is-small" /> -->
              </button>
            </div>
          </b-table-column>

          <section class="section" slot="empty">
            <div class="content has-text-grey has-text-centered">
              <template v-if="isLoading">
                <p>
                  <b-icon icon="dots-horizontal" size="is-large" />
                </p>
                <p>Fetching data...</p>
              </template>
              <template v-else>
                <p>
                  <b-icon icon="emoticon-sad" size="is-large" />
                </p>
                <p>Nothing's here&hellip;</p>
              </template>
            </div>
          </section>
        </b-table>
      </card-component>

      <modal-box :isActive="isActive" @hideModal="close">
        <card-component
          v-if="isViewAdvert"
          title="Advert Campaign"
          icon="account"
        >
          <hr />
          <b-field label="Name">
            <b-input :value="item.name" custom-class="is-static" readonly />
          </b-field>
          <b-field label="From">
            <b-input :value="item.from" custom-class="is-static" readonly />
          </b-field>
          <b-field label="To">
            <b-input :value="item.to" custom-class="is-static" readonly />
          </b-field>
          <b-field label="Total Budget">
            <b-input
              :value="item.total_budget"
              custom-class="is-static"
              readonly
            />
          </b-field>
          <b-field label="Daily Budget">
            <b-input
              :value="item.daily_budget"
              custom-class="is-static"
              readonly
            />
          </b-field>
          <hr />

          <button class="button is-small" type="button" @click="close">
            close
          </button>
        </card-component>
      </modal-box>
    </section>
  </div>
</template>

<script>
import CardComponent from "@/components/CardComponent";
import ModalBox from "@/components/ModalBox";
import TitleBar from "@/components/TitleBar";
import HeroBar from "@/components/HeroBar";
import CardToolbar from "@/components/CardToolbar";

export default {
  name: "AdvertIndex",
  components: {
    CardToolbar,
    HeroBar,
    TitleBar,
    ModalBox,
    CardComponent,
  },
  data() {
    return {
      isActive: false,
      adverts: [],
      isLoading: false,
      paginated: false,
      perPage: 10,
      checkedRows: [],
      userId: this.$store.state.userId,
      item: null,
      gallery: [],
      isGallery: false,
    };
  },
  computed: {
    isViewAdvert() {
      return !!this.item;
    },
  },
  created() {
    this.getData();
  },
  methods: {
    getData() {
      this.isLoading = true;
      axios
        .get(`/api/advertisements/${this.userId}`)
        .then((r) => {
          this.isLoading = false;
          if (r.data && r.data.data) {
            if (r.data.data.length > this.perPage) {
              this.paginated = true;
            }

            this.adverts = r.data.data;
          }
        })
        .catch((err) => {
          this.isLoading = false;
          this.$buefy.toast.open({
            message: `Error: ${err.message}`,
            type: "is-danger",
            queue: false,
          });
        });
    },
    viewAdvert(item) {
      this.item = item;
      this.isActive = true;
    },
    close() {
      this.item = null;
      this.isActive = false;
    },
    previewImage(item) {
      this.isGallery = true;
      this.gallery = [];

      const images = JSON.parse(item.banner_image_path);
      images.map((v) =>
        this.gallery.push({
          src: `storage/${v.replace("public/", "")}`,
          thumbnailWidth: "200px",
        })
      );
    },
  },
};
</script>
