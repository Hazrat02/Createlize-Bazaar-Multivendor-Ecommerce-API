<template>
  <AdminLayout>
    <div class="title-wrapper pt-30">
      <div class="row align-items-center">
        <div class="col-md-6">
          <div class="title mb-30">
            <h2>SMTP Manage</h2>
            <p class="text-sm text-muted">Configure mail delivery and templates</p>
          </div>
        </div>
      </div>
    </div>

    <form @submit.prevent="submit">
      <div class="row">
        <div class="col-lg-6">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">SMTP Configuration</h6>
              <div class="row">
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Mailer</label>
                    <input v-model="form.mailer" type="text" class="form-control" placeholder="smtp" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="input-style-1">
                    <label>Host</label>
                    <input v-model="form.host" type="text" class="form-control" placeholder="smtp.example.com" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>Port</label>
                    <input v-model.number="form.port" type="number" class="form-control" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>Username</label>
                    <input v-model="form.username" type="text" class="form-control" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>Password</label>
                    <input v-model="form.password" type="password" class="form-control" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>Encryption</label>
                    <input v-model="form.encryption" type="text" class="form-control" placeholder="tls" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>From address</label>
                    <input v-model="form.from_address" type="email" class="form-control" />
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="input-style-1">
                    <label>From name</label>
                    <input v-model="form.from_name" type="text" class="form-control" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Email Template</h6>
              <div class="input-style-1">
                <label>Template subject</label>
                <input v-model="form.template_subject" type="text" class="form-control" />
                <div class="text-sm text-muted mt-2">
                  Tokens:
                  <code v-pre>{{name}}</code>,
                  <code v-pre>{{email}}</code>,
                  <code v-pre>{{subject}}</code>
                </div>
              </div>
              <div class="input-style-1">
                <label>Template body (HTML)</label>
                <textarea v-model="form.template_body" rows="8" class="form-control"></textarea>
                <div class="text-sm text-muted mt-2">
                  Tokens:
                  <code v-pre>{{message}}</code>
                </div>
              </div>
              <button type="submit" class="main-btn primary-btn btn-hover" :disabled="form.processing">
                {{ form.processing ? 'Saving...' : 'Save' }}
              </button>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card-style mb-30">
            <div class="card-content">
              <h6 class="text-medium mb-3">Email Preview</h6>
              <div class="email-preview">
                <div class="preview-subject">
                  Subject: {{ subjectPreview }}
                </div>
                <iframe
                  class="preview-frame"
                  title="Email preview"
                  sandbox="allow-same-origin"
                  :srcdoc="bodyPreview"
                ></iframe>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue'
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
  settings: { type: Object, default: () => ({}) },
})

const defaultTemplateBody = `<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Createlize Email</title>
  <style>
    body { margin:0; padding:0; background:#f6f8fc; }
    .wrap { background:#f6f8fc; padding:24px 0; }
    .cardx {
      max-width:680px; margin:0 auto; background:#ffffff;
      border:1px solid #e9eef6; border-radius:16px; overflow:hidden;
      font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
    }
    .header {
      background: linear-gradient(135deg, #0b5ed7, #0dcaf0);
      color:#fff; padding:18px 22px;
    }
    .badge {
      display:inline-block; padding:6px 10px; border-radius:999px;
      background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25);
      font-size:12px;
    }
    .content { padding:22px; color:#111827; font-size:15px; line-height:1.6; }
    .content p { margin:0 0 12px; }
    .footer {
      padding:16px 22px; border-top:1px solid #eef2f7;
      background:#fbfcfe; color:#6b7280; font-size:13px;
    }
    .btnx {
      display:inline-block; padding:10px 14px; border-radius:12px;
      background:#0b5ed7; color:#fff; text-decoration:none; font-weight:600;
    }
  </style>
</head>
<body style="margin:0; padding:0; background:#f6f8fc;">
  <div class="wrap" style="background:#f6f8fc; padding:24px 0;">
    <div class="cardx" style="max-width:680px; margin:0 auto; background:#ffffff; border:1px solid #e9eef6; border-radius:16px; overflow:hidden; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;">
      <div class="header" style="background:linear-gradient(135deg,#0b5ed7,#0dcaf0); color:#fff; padding:18px 22px;">
        <div class="badge" style="display:inline-block; padding:6px 10px; border-radius:999px; background:rgba(255,255,255,.18); border:1px solid rgba(255,255,255,.25); font-size:12px;">
          Createlize • @createlize.org
        </div>
        <div style="margin-top:10px; font-size:18px; font-weight:800; letter-spacing:.3px;">
          Message from Createlize
        </div>
      </div>
      <div class="content" style="padding:22px; color:#111827; font-size:15px; line-height:1.6;">
        <p style="margin:0 0 12px;">Hi {{name}},</p>
        <p style="margin:0 0 12px;">{{message}}</p>
        <div style="margin:16px 0 6px;">
          <a class="btnx" href="wa.me/+8801783195999" style="display:inline-block; padding:10px 14px; border-radius:12px; background:#0b5ed7; color:#fff; text-decoration:none; font-weight:600;">
            View / Reply
          </a>
        </div>
        <p style="margin:14px 0 0;">
          Thanks,<br/>
          <strong>Createlize Bazaar</strong>
        </p>
      </div>
      <div class="footer" style="padding:16px 22px; border-top:1px solid #eef2f7; background:#fbfcfe; color:#6b7280; font-size:13px;">
        Need help? Email us at <a href="mailto:bazaar@createlize.org" style="color:#0b5ed7; text-decoration:none;">bazaar@createlize.org</a><br/>
        © 2025 Createlize. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>`;

const form = useForm({
  mailer: props.settings.mailer || 'smtp',
  host: props.settings.host || '',
  port: props.settings.port || 587,
  username: props.settings.username || '',
  password: props.settings.password || '',
  encryption: props.settings.encryption || 'tls',
  from_address: props.settings.from_address || '',
  from_name: props.settings.from_name || '',
  template_subject: props.settings.template_subject || 'Message from Createlize',
  template_body: props.settings.template_body || defaultTemplateBody,
})

const sample = {
  name: 'Demo User',
  email: 'user@example.com',
  subject: 'Welcome to Createlize',
  message: 'Thanks for joining! Let us know if you need any help.',
}

const subjectPreview = computed(() => replaceTokens(form.template_subject || '', sample))

const bodyPreview = computed(() => replaceTokens(form.template_body || '', sample))

function replaceTokens(text, values) {
  return text
    .replaceAll('{{name}}', values.name)
    .replaceAll('{{email}}', values.email)
    .replaceAll('{{subject}}', values.subject)
    .replaceAll('{{message}}', values.message)
}

function submit() {
  form.post('/admin/smtp')
}
</script>

<style scoped>
.email-preview {
  border: 1px solid #e5e7eb;
  border-radius: 12px;
  padding: 16px;
  background: #fff;
}

.preview-subject {
  font-weight: 600;
  margin-bottom: 10px;
}

.preview-body {
  font-size: 14px;
  color: #111827;
}

.preview-frame {
  width: 100%;
  min-height: 420px;
  border: 1px solid #e5e7eb;
  border-radius: 10px;
}
</style>
