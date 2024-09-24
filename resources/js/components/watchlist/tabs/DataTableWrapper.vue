<!-- DataTableWrapper.vue -->
<template>
  <div class="table-responsive">
    <DataTable
      :class="tableClass"
      :id="tableId"
      :data="data"
      :columns="columns"
      :key="tableKey"
      :options="options"
    />
  </div>
</template>

<script>
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net';
import 'datatables.net-dt/css/jquery.dataTables.css';

DataTable.use(DataTablesCore);

export default {
  name: 'DataTableWrapper',
  components: {
    DataTable,
  },
  props: {
    data: {
      type: Array,
      required: true,
    },
    columns: {
      type: Array,
      required: true,
    },
    tableKey: {
      type: [String, Number],
      required: true,
    },
    options: {
      type: Object,
      default: () => ({}),
    },
    tableId: {
      type: String,
      default: '',
    },
    tableClass: {
      type: String,
      default: 'display table fw-bold',
    },
  },
};
</script>
