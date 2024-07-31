<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import type { ComponentSize, FormInstance, FormRules } from 'element-plus'
import { Head,useForm } from '@inertiajs/vue3';
import {ref} from 'vue'
import { error } from '@/Components/mixin.js';



defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    }
});

const verificationForm = useForm({
    one_time_password: '',
});
const verificationFormRef = ref(null)

const submitVerification = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            verificationForm.post(route('2fa-verify-submit'), {

            });
        } else {
            error('Something went wrong!.');
        }
    })
}

</script>

<template>
    <Head title="Profile" />

    <AuthenticatedLayout>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">LogIn</h2>

                        <p class="mt-1 text-sm text-gray-600">
                            Please enter the <strong>OTP</strong> generated on your Authenticator App.<br>
                            Ensure you submit the current one because it refreshes every 30 seconds.
                        </p>
                    </header>

                    <el-form ref="verificationFormRef" :model="verificationForm" class="mt-5" >
                        <el-form-item label-position="top" label="One Time Password" prop="one_time_password" :rules="[{ required: true,message: 'Please Enter OTP',trigger: ['blur','input']}]" >
                            <el-input v-model="verificationForm.one_time_password" style="width: 30%;" placeholder="OTP" />
                        </el-form-item>
                        <el-button type="primary" @click="submitVerification(verificationFormRef)">Login</el-button>
                    </el-form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
