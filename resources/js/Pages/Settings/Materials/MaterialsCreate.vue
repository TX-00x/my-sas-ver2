<template>
  <settings-layout>
    <div class="">
      <h3 class="text-lg">Material Create</h3>
      <div class="mt-5">
        <form @submit.prevent="addMaterial">
          <div class="shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 bg-white sm:p-6">
              <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                  <label for="material_name" class="block text-sm font-medium text-gray-700">Material Name</label>
                  <input v-model="material.name" type="text" name="material_name" id="material_name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="material_type" class="block text-sm font-medium text-gray-700">Type</label>
                  <select v-model="material.type" id="material_type" name="material_type" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="material_type in material_types" :value="material_type.type"> {{ material_type.name }}</option>
                  </select>
                </div>

                <div class="col-span-6 sm:col-span-3">
                  <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                  <select v-model="material.unit" id="unit" name="unit" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option v-for="unit in units" :value="unit.type"> {{ unit.name }}</option>
                  </select>
                </div>

                <div v-if="material.type == 'fabric'" class="col-span-6 sm:col-span-3">
                  <label for="fiber_content" class="block text-sm font-medium text-gray-700">Fiber Content</label>
                  <input v-model="material.fiber_content" type="text" name="fiber_content" id="fiber_content" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>

              </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
              <inertia-link href="/settings/materials" class="inline-flex justify-center text-sm font-medium rounded-md text-gray-900 mr-5">
                Cancel
              </inertia-link>

              <button
                  type="submit"
                  class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
                  :class="{'opacity-50': submitted}"
              >
                Create
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </settings-layout>
</template>

<script>
import SettingsLayout from "@/Pages/Settings/SettingsLayout";

export default {
  name: "MaterialsCreate",
  components: {SettingsLayout},
  props: {
    material_types: {
      required: true,
      type: Array
    },
    units: {
      required: true,
      type: Array
    }
  },
  data() {
    return {
      material: {
        name: '',
        type: '',
        unit: '',
        fiber_content: ''
      },
      submitted: false,
    }
  },
  mounted() {

  },
  methods: {
    addMaterial() {
      this.submitted = true;
      this.$inertia.post('/settings/materials', this.material).then(function () {
        this.submitted = false;
      }).catch(error => {
        this.submitted = false;
      })
    }
  },
}
</script>

<style scoped>

</style>
