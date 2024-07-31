<script lang="ts" setup>
import type { ComponentSize, FormInstance, FormRules } from 'element-plus'
import { Link, useForm, usePage } from '@inertiajs/vue3';
import ElModal from '@/Components/ElModal.vue';
import { reactive,ref } from 'vue';
import { error } from '@/Components/mixin.js';
import axios from 'axios';

const authenticatorForm = useForm({
    enable: false,
    qr_code : '',
    otp : ''
});

const user = usePage().props.auth.user;


const authenticatorFormRef = ref(null);

const submitAuthenticator = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            authenticatorForm.post(route('profile.set2fa'), {

            });
        } else {
            error('Please solve errors first!.');
        }
    })
}

const getAuthCode = async () => {
    let response = await axios.post(route('profile.get2fa'))
    if(response.data.success){
        authenticatorForm.enable = true,
        authenticatorForm.qr_code = response.data.qr_code,
        authenticatorForm.otp = ""
    }
}
</script>
<template>
    <ElModal
        v-model="authenticatorForm.enable"
        title="Add 2-step verification Device"
        :close-on-press-escape="false"
        :close-on-click-modal="false"
    >
    <center>
        <el-form ref="authenticatorFormRef" :model="authenticatorForm" >
            Set up your two factor authentication  by scanning the barcode below with you Google Authenticator App
            <div v-html="authenticatorForm.qr_code"></div>
            <div>
                <el-form-item prop="otp" :rules="[{ required: true,message: 'Please Enter OTP from Authenticator',trigger: ['blur','input']}]" >
                    <el-input v-model="authenticatorForm.otp" style="width: 30%;" placeholder="OTP" />
                </el-form-item>
            </div>
        </el-form>
    </center>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="authenticatorForm.enable = false">Cancel</el-button>
                <el-button type="primary" @click="submitAuthenticator(authenticatorFormRef)">
                Confirm
                </el-button>
            </div>
        </template>
    </ElModal>

    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">2-Step Verification</h2>
        </header>

        <form  class="mt-6 space-y-6">
            <el-button type="primary" @click="getAuthCode">Add New Device</el-button>
        </form>
    </section>
</template>
