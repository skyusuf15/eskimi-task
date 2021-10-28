<template>
  <footer v-show="isFooterBarVisible" class="footer">
    <div class="container-fluid">
      <div class="level">
        <div class="level-left">
          <div class="level-item">
            <div class="footer-copyright">
              <b>&copy; {{ year }}, Eskimi SSP</b>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>

<script>
import dayjs from "dayjs";
import { mapState } from "vuex";

export default {
  name: "FooterBar",
  computed: {
    year() {
      return dayjs().year();
    },
    ...mapState(["isFooterBarVisible"]),
  },
};
</script>
