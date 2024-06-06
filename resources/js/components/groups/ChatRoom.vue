<template>
    <section class="chats_main">
      <div class="container-fluid">
        <div class="d-flex px-lg-3">
          <div>
            <div class="all_chats">
              <h2 class="fs-2 fw-bold icon-heading">Chats</h2>
              <form action="">
                <input v-model="searchQuery" type="search" placeholder="search group" class="search_group">
              </form>
              <div class="all_groups">
                <div v-for="chat in filteredChats" :key="chat.id" @click="selectGroup(chat)" class="group_card d-flex gap-2 align-items-center group_card_chat">
                  <div class="group_avatar">
                    <img
                      v-if="!chat.avatarFailed && chat.avatar"
                      :src="'uploads/' + chat.avatar"
                      class="card-img-top"
                      :alt="chat.group_title + ' Profile Picture'"
                      @error="handleAvatarError(chat)"
                    >
                    <div v-else class="avtar_group_name d-flex">
                      <p class="px-2">{{ chat.group_name }}</p>
                    </div>
                  </div>
                  <div class="group_info">
                    <div class="d-flex justify-content-between">
                      <h3 class="fs-4 mb-1 text-oneline">{{ chat.group_title }}</h3>
                      <span class="unread_count">9+</span> 
                    </div>
                    <div class="d-flex gap-1">
                      <p class="text-oneline mb-0">{{ chat.group_name }}</p>
                      <span>2d</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="grow-1 px-3">
            <div class="active_chat">
              <div class="chat_header pb-2" v-if="selectedGroup">
                <div class="d-flex gap-2 align-items-center">
                  <div class="group_avatar">
                    <img v-if="!selectedGroup.avatarFailed && selectedGroup.avatar" :src="'uploads/' + selectedGroup.avatar" :alt="selectedGroup.group_name" />
                    <div v-else class="avtar_group_name d-flex">
                      <p class="px-2">{{ selectedGroup.group_name }}</p>
                    </div>
                  </div>
                  <div class="group_info">
                    <h3 class="fs-4 mb-1">{{ selectedGroup.group_title }}</h3>
                  </div>
                </div>
              </div>
              <div class="chat_body">
                <LiveChat v-if="selectedGroup" :groupId="selectedGroup.group_id" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </template>
  
  <script>
  import { mapState, mapActions } from 'vuex';
  import LiveChat from './LiveChat.vue';  // Import the LiveChat component
  
  export default {
    name: 'UserGroups',
    components: {
      LiveChat
    },
    data() {
      return {
        selectedGroup: null,  // Add a selectedGroup data property
        searchQuery: '',  // Add a searchQuery data property
      };
    },
    computed: {
      ...mapState('UserGroups', ['suggestedChats', 'joinedChats', 'isLoading', 'error']),
      filteredChats() {
        if (!this.searchQuery) {
          return this.joinedChats;
        }
        const query = this.searchQuery.toLowerCase();
        return this.joinedChats.filter(chat => chat.group_title.toLowerCase().includes(query) || chat.group_name.toLowerCase().includes(query));
      }
    },
    created() {
      this.fetchJoinedChats();
    },
    watch: {
      joinedChats(newChats) {
        if (newChats.length && !this.selectedGroup) {
          this.selectGroup(newChats[0]);
        }
      }
    },
    methods: {
      ...mapActions('UserGroups', [ 'fetchJoinedChats']),
      onChatJoined() {
        this.fetchJoinedChats();
      },
      handleAvatarError(chat) {
        chat.avatarFailed = true;
      },
      selectGroup(chat) {
        this.selectedGroup = chat;  // Set the selectedGroup when a group card is clicked
      },
    },
  };
  </script>  
  
  <style>
  .unread_count{
    background: #ff0000c9;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #fff;
    height: 15px;
    font-size: 10px;
    border-radius: 40px;
    box-shadow: 0px 0px 4px red;
    padding: 0px 5px;
    animation: un_read 1s linear alternate infinite;
  }
  .avtar_group_name p {
    margin: 0;
    width: 50px;
    color: white;
    background-color: #183B56;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: inset 0px 0px 7px #fff;
    font-size: 9px;
    font-style: italic;
  }
  .all_chats {
    padding-top: 20px;
    border-right: 1px solid #ccc;
    height: 100%;
  }
  .grow-1 {
    flex-grow: 1;
  }
  .search_group {
    padding: 10px;
    width: 100%;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin: 10px 0px 20px 0px;
  }
  .text-oneline {
    width: 220px;
  }
  .group_card_chat {
    background-color: #f3f3f3;
    border-radius: 4px;
    padding: 10px;
    margin-bottom: 10px;
    transition: .5s ease;
    cursor: pointer;
    justify-content: space-evenly;
  }
  .group_card_chat:hover {
    background-color: #ededed;
  }
  .all_groups {
    max-height: 70vh;
    overflow: auto;
  }
  .active_chat {
    padding-top: 20px;
  }
  .all_groups::-webkit-scrollbar {
    width: 2px;
  }
  .chat_header{
    border-bottom: 1px solid #ccc;
  }
 .chat_body .chat-text-sec {
    height: calc(100vh - 181px) !important;
}
@keyframes un_read {
  from{
    box-shadow: 0px 0px 4px red;
  }
  to{
    box-shadow: 0px 0px 8px red;
  }
}
  @media screen and (min-width: 992px) {
    .all_chats {
        min-width: 335px;
    }
  }
  @media screen and (max-width: 992px) {
    .text-oneline {
      width: 180px;
    }
  }
  @media screen and (max-width: 768px) {
    .all_groups .group_info, .all_chats h2, .search_group {
      display: none;
    }
    .group_card_chat {
      background-color: transparent;
    }
  }
  </style>  