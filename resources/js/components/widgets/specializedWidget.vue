<template>
    
        <div v-if="filteredWidgets.length">
            <div v-for="widget in filteredWidgets" :key="widget.id">
                <h4 class="fs-4 fw-6 px-2 mb-2 icon-short-heading d-flex align-items-center">Stock Information</h4>
                <div class="mt-3 overflow-auto market-table-wrapper">
                    <table class="table border mb-0">
                        <thead>
                        <tr>
                            <th class="fw-6">Symbol</th>
                            <th class="text-end fw-6">Last</th>
                        </tr>
                        </thead>
                        <tbody v-if="widget.symbols">
                        <tr v-for="(widgetData, key) in widget.symbols" :key="key" class="stockrow">
                            <td class="fw-5">
                                <span v-if="!widgetData.symbol">
                                    <Skeletor width="40px" />
                                </span>
                                <span v-else>{{ widgetData.symbol }}</span>
                                <br>
                                <span v-if="!widgetData.name">
                                    <Skeletor width="40px" />
                                </span>
                                <span v-else>{{ widgetData.name }}</span>
                                <div class="StockInfoBtn">
                                    <a :href="'/quotes/' + widgetData.symbol" class="btn btn-primary fs-14 px-3" aria-label="Stock Quote">
                                        More About {{ widgetData.name }}
                                    </a>
                                </div>
                            </td>
                            <td class="text-end fw-5">
                                <span v-if="!widgetData.price">
                                    <Skeletor width="40px" />
                                </span>
                                <span v-else>{{ widgetData.price }}</span>
                                <br>
                                <span class="me-2" v-if="!widgetData.volume">
                                    <Skeletor width="40px" />
                                </span>
                                <span v-else>
                                    {{ widgetData.volume }}
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div v-else-if="isLoading" class="text-center">
            <h4 class="fs-5 fw-6 px-2 mb-2 icon-short-heading d-flex align-items-center"><Skeletor width="100px" /></h4>
                <div class="mt-3 overflow-auto market-table-wrapper">
                    <table class="table border">
                        <thead>
                        <tr>
                            <th class="fw-6 text-start"><Skeletor width="80px" /></th>
                            <th class="text-end fw-6"><Skeletor width="70px" /></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="fw-5  text-start">
                                <Skeletor width="40px" />
                                <br>
                                <Skeletor width="40px" />
                            </td>
                            <td class="text-end fw-5">
                                <Skeletor width="40px" />
                                <br>
                                <span class="me-2">
                                    <Skeletor width="40px" />
                                </span>
                                <span>
                                    <Skeletor width="40px" />
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
        </div>
        <div v-else class="text-center">
            <p>No data available.</p>
        </div>
    
  </template>
  
  <script>
  import { mapState, mapActions } from 'vuex';
  import "vue-skeletor/dist/vue-skeletor.css";
  import { Skeletor } from "vue-skeletor";
  import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
  import userWidgetsModule from '@/stores/widgetsStore';
  
  
  export default {
    components: {
      Skeletor,
    },
    props: {
      category: String,
      subCategory: String,
      postId: Number,
    },
    data() {
      return {
        moduleRegistered: false,
      };
    },
    computed: {
      ...mapState('userWidgets', ['widgets', 'isLoading']),
      categoryTitle() {
        return this.subCategory || this.category;
      },
      filteredWidgets() {
        if (!this.postId || !this.widgets.length) return this.widgets;
        
        const widgetMappings = {
          433883: [35], // Widget ID 35 for post ID 433883
          434025: [36],  // Widget ID 36 for post ID 434025
          434081: [37]  // Widget ID 37 for post ID 434081
        };
      
        const allowedWidgetIds = widgetMappings[this.postId] || [];
        
        if (allowedWidgetIds.length) {
          return this.widgets.filter(widget => allowedWidgetIds.includes(widget.id));
        }
        
        return this.widgets;
      }
    },
    created() {
      this.registerModuleAndFetchWidgets();
  
    },
    beforeDestroy() {
      this.unregisterModule();
    },
    methods: {
      ...mapActions('userWidgets', ['getWidgetsByCategory']),
      
      registerModuleAndFetchWidgets() {
        if (!this.$store.hasModule('userWidgets')) {
          registerVuexModule('userWidgets', userWidgetsModule);
          this.moduleRegistered = true;
        }
        this.fetchWidgets();
      },
  
      unregisterModule() {
        if (this.moduleRegistered) {
          unregisterVuexModule('userWidgets');
        }
      },
  
      fetchWidgets() {
        const { category, subCategory } = this.$route.params;
        this.getWidgetsByCategory({ category: 'Specialized Reports', subCategory });
      },
    },
  };
  </script>
  
  <style>
  tr{position: relative;}
  .StockInfoBtn{
    display:none;
    position: absolute;
    width: 100%;
    left: 0;
    padding: 13px;
    text-align: end;
    bottom: 0;
  }
  .stockrow:hover .StockInfoBtn{
    display: inline-block;
  }
  .dividers {
    width: 1px;
    background-color: var(--Blue-Koi);
    height: 15px;
  }
  
  .market-table-wapper::-webkit-scrollbar {
    height: 6px;
  }
  </style>