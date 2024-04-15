<template>
  <n-layout style="height: 540px" has-sider>
    <n-layout style="padding-left: 8px" :inverted="inverted">
      <PageHeader title="Grama Niladari Details Management" />
      <div class="flex justify-end pb-6">
        <n-space>
          <n-button @click="addNewGramaNiladari">
            <template #icon
              ><n-icon><add-icon /></n-icon></template
            >Add New Grama Niladari</n-button
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
          :data="gramaNiladaris"
          :bordered="false"
        />
      </n-space>
    </n-layout>
    <edit-grama-niladari-modal
      :gramaNiladari="selectedGramaNiladari"
      :is-showing="isShowingEditGramaNiladariModal"
      @close="isShowingEditGramaNiladariModal = $event"
      @save="fetchGramaNiladari"
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
import EditGramaNiladariModal from "@/components/Admin/EditGNOfficerModal.vue";
import PageHeader from "@/components/PageHeader.vue";
const isShowingEditGramaNiladariModal = ref(false);
const selectedGramaNiladari = ref(false);
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
const gramaNiladaris = ref([]);
const columns = [
  {
    title: "Name",
    key: "name",
  },
  {
    title: "NIC",
    key: "nic",
  },
  {
    title: "Address",
    key: "address",
  },
  {
    title: "Contact Number",
    key: "contact_number",
  },
  // {
  //   title: "Role",
  //   key: "role",
  // },
  {
    title: "DOB",
    key: "date_of_birth",
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
            selectedGramaNiladari.value = row;
            isShowingEditGramaNiladariModal.value = true;
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
            await deleteGramaNiladari(row);
            await fetchGramaNiladari();
          },
        },
        { default: () => "Delete" }
      );
    },
  },
];

const components = {
  PageHeader,
};

onMounted(() => {
  fetchGramaNiladari();
});

function addNewGramaNiladari() {
  selectedGramaNiladari.value = {
    id: "",
    name: "",
    nic: "",
    address: "",
    contact_number: "",
    role: "",
    date_of_birth: "2000-12-01",
  };

  isShowingEditGramaNiladariModal.value = true;
}

function renderIcon(icon) {
  return () => h(NIcon, null, { default: () => h(icon) });
}
async function fetchGramaNiladari()   {
  isLoading.value = true;
  const { data } = await Http.get("gramaNiladari");
  isLoading.value = false;
  gramaNiladaris.value = data.data;
}

async function deleteGramaNiladari(gramaNiladari) {
  isLoading.value = true;
  await Http.delete(`gramaNiladari/${gramaNiladari.id}`);
  isLoading.value = false;
}
</script>
