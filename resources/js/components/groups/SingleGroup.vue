<template>
    <div class="container my-4">
        <ProfileGroupHeader context="groupHeader" ref="ProfileGroupHeader" :id="group_id" />
        <div class="row">
            <div class="col-lg-8">
                <div class="bg-transparent py-0 single-group-chats">
                    <ul class="nav border-0 m-0 p-0 gap-1" id="chats-content-tab" role="tablist">
                        <li class="nav-item border-0" role="presentation" v-if="groupData.isJoined">
                            <router-link
                                :to="{ name: 'group-discussion', params: { group_id: group_id, group_name: group_name } }"
                                class="nav-link border-0 rounded-top fs-16 fw-bold bg-light-grey text-secondary"
                                :class="{ active: $route.name === 'group-discussion' }">
                                    Group Discussion
                            </router-link>                         
                        </li>
                        <li class="nav-item" role="presentation">
                            <router-link
                                :to="{ name: 'group-live-chat', params: { group_id: group_id, group_name: group_name } }"
                                class="nav-link border-0 rounded-top bg-light-grey fs-16 fw-bold text-secondary"
                                :class="{ active: $route.name === 'group-live-chat' }">
                                    Live Chat
                            </router-link>
                        </li>
                        <li class="nav-item" role="presentation" v-if="groupData.isJoined">
                            <router-link
                                :to="{ name: 'group-members', params: { group_id: group_id, group_name: group_name } }"
                                class="nav-link border-0 rounded-top bg-light-grey fs-16 fw-bold text-secondary"
                                :class="{ active: $route.name === 'group-members' }">
                                    Members
                            </router-link>
                        </li>
                    </ul>
                </div>
                <div class="tab-content bg-white shadow" id="mychatsContent">
                    <router-view></router-view>
                </div>
            </div>
            <div class="col-lg-4">
                <Markets />
                <GroupChats />
            </div>

        </div>
    </div>
</template>

<script>
import { mapState } from 'vuex';
import ProfileGroupHeader from '../header/ProfileGroupHeader.vue';
import GroupChats from '../widgets/GroupChatsSidebar.vue';
import Markets from '../widgets/Markets.vue';
import { registerVuexModule, unregisterVuexModule } from '@/stores/registerModule';
import userGroupsModule from '@/stores/groupStore';

export default {
    name: 'SingleGroup',
    components: {
        ProfileGroupHeader,
        GroupChats,
        Markets
    },
    computed: {
        ...mapState('userGroup', ['groupData']),
    },
    data() {
        return {
            moduleRegistered: false,
            group_id: null,
            group_name: null,
        }
    },
    created() {
        if (!this.$store.hasModule('userGroup')) {
          registerVuexModule('userGroup', userGroupsModule);
          this.moduleRegistered = true;
          console.log('Registered Module');
        }
        this.group_id = this.$route.params.group_id;
        this.group_name = this.$route.params.group_name;
    },
    beforeDestroy() {
        if (this.moduleRegistered) {
          unregisterVuexModule('userGroup');
        }
    }
}
</script>

