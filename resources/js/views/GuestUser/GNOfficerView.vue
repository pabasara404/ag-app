<template>
  <n-layout style="height: 540px" has-sider>
    <n-layout style="padding-left: 8px" :inverted="inverted">
      <PageHeader title="GN Officer Details Management" />
      <div class="flex justify-end pb-6">
        <n-space>
          <n-button @click="addNewGNOfficer">
            <template #icon
              ><n-icon><add-icon /></n-icon></template
            >Add New GN Officer</n-button
          >
          <n-dropdown :options="options" placement="bottom-start">
            <n-button :bordered="false" style="padding: 0 4px"> ··· </n-button>
          </n-dropdown>
        </n-space>
      </div>

      <n-space vertical>
        <n-data-table
          :loading="isLoading"
          :columns="columns"
          :data="GNOfficers"
          :bordered="false"
        />
      </n-space>
    </n-layout>
    <EditGNOfficerModal
      :GNOfficer="selectedGNOfficer"
      :is-showing="isShowingEditGNOfficerModal"
      @close="handleEditGNOfficerModalClose"
    />
  </n-layout>
</template>

<script setup>
import { h, onMounted, ref } from "vue";
import {
  PencilSharp as PencilIcon,
  Add as AddIcon,
  TrashBin as TrashBinIcon,
  Eye as EyeIcon,
} from "@vicons/ionicons5";
import Http from "@/services/http";
import { NButton, NIcon } from "naive-ui";
import EditGNOfficerModal from "@/components/Admin/EditGNOfficerModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditGNOfficerModal = ref(false);
const selectedGNOfficer = ref(false);
const inverted = ref(false);
const isLoading = ref(false);
const options = [
  {
    label: "Sort By Recently Added",
    key: "1",
  },
  {
    label: "Sort By Oldest Added",
    key: "2",
  },
];
const GNOfficers = ref([]);
const columns = [
  {
    title: "Name",
    key: "name",
  },
  {
    title: "Contact Number",
    key: "contact_number",
  },
  {
    title: "",
    key: "actions",
    render(row) {
      return h(
        NButton,
        {
          round: true,
          type: "info",
          strong: true,
          secondary: true,
          // renderIcon: EyeIcon,
          size: "small",
          onClick: () => {
            selectedGNOfficer.value = row;
            isShowingEditGNOfficerModal.value = true;
          },
        },
        { default: () => "View" }
      );
    },
  },
  {
    title: "",
    key: "actions",
    render(row) {
      return h(
        NButton,
        {
          round: true,
          type: "info",
          strong: true,
          secondary: true,
          size: "small",
          onClick: async () => {
            await deleteGNOfficer(row);
            await fetchGNOfficer();
          },
        },
        { default: () => "Delete" }
      );
    },
  },
];

onMounted(() => {
  fetchGNOfficer();
});

function handleEditGNOfficerModalClose(){
    isShowingEditGNOfficerModal.value = false;
    fetchGNOfficer();
}

function addNewGNOfficer() {
  selectedGNOfficer.value = {
    id: "",
    name: "",
    contact_number: "",
      email:""
  };

  isShowingEditGNOfficerModal.value = true;
}

function renderIcon(icon) {
  return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchGNOfficer()   {
  isLoading.value = true;
  const { data } = await Http.get("gnOfficer");
  isLoading.value = false;
  GNOfficers.value = data.data;
}

async function deleteGNOfficer(GNOfficer) {
  isLoading.value = true;
  await Http.delete(`gnOfficer/${GNOfficer.id}`);
  isLoading.value = false;
}
</script>
