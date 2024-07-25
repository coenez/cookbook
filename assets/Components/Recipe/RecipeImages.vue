<script setup>
const props = defineProps({
  images: Array,
  editable: Boolean,
})

const removeImage = (index) => {
  if (props.images[index]) {
    delete props.images[index]
  }
}
</script>

<template>

  <v-row v-if="images.length > 0" align="center" class="fill-height">
    <template v-for="(image, imageIndex) in images" :key="imageIndex">
      <v-col md="4" cols="6">
        <v-hover v-slot="{ isHovering, props }" v-if="image">
          <v-card variant="outlined" border="thin" :class="{ 'on-hover': isHovering }" v-bind="props">
            <v-img :src="image.path" aspect-ratio="1" cover max-height="250">
              <template v-slot:placeholder>
                <div class="d-flex align-center justify-center fill-height">
                  <v-progress-circular
                      color="grey-lighten-4"
                      indeterminate
                  ></v-progress-circular>
                </div>
              </template>
              <v-btn v-if="editable" class="float-right" icon="mdi-trash-can-outline" size="x-large" @click="removeImage(imageIndex)" />
            </v-img>
          </v-card>
        </v-hover>
      </v-col>
    </template>
  </v-row>
</template>

<style scoped>
.v-card {
  transition: opacity .4s ease-in-out !important;
}

.v-card:not(.on-hover) {
  opacity: 0.6 !important;
}
</style>