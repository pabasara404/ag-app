<script setup>

</script>

<template>
  <tr>
    <td>
      <n-input v-model:value="rowData.sub_no" />
    </td>
    <td>
      <n-input v-model:value="rowData.type" />
    </td>
    <td>
      <n-input v-model:value="rowData.height" />
    </td>
    <td>
      <n-input v-model:value="rowData.girth" />
    </td>
    <td>
      <n-input v-model:value="rowData.fruit_status" />
    </td>
    <td>
      <n-input v-model:value="rowData.age" />
    </td>
    <td>
      <n-button type="error" @click="removeRow">Remove</n-button>
    </td>
  </tr>
</template>


<style scoped>

</style>