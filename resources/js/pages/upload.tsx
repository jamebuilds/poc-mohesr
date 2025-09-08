import { store } from '@/actions/App/Http/Controllers/UploadController';
import Heading from '@/components/heading';
import InputError from '@/components/input-error';
import { Alert, AlertDescription } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Transition } from '@headlessui/react';
import { Form, Head } from '@inertiajs/react';

export default function Upload() {
    return (
        <>
            <Head title="Upload Credential" />

            <div className="min-h-screen bg-slate-50 dark:bg-slate-900">
                <div className="mx-auto max-w-2xl px-6 py-16">
                    <div className="mb-12 text-center">
                        <Heading title="POC - MOHESR" />
                        <p className="mt-3 text-slate-600 dark:text-slate-400">
                            Upload a valid credential and get re-issued by "Accredify Dev Team" Organization in UAT.
                        </p>
                    </div>

                    <div className="rounded-lg border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div className="mb-8">
                            <h2 className="mb-4 text-lg font-medium text-slate-900 dark:text-slate-100">What is happening?</h2>
                            <ol className="space-y-2 text-sm text-slate-600 dark:text-slate-400">
                                <li>1. Verify uploaded file against UAT's "Accredify Dev Team" organization</li>
                                <li>2. Extract some data and trigger workflow API in UAT's "Accredify Dev Team" organization</li>
                            </ol>
                        </div>

                        <Form className="space-y-6" action={store()} resetOnSuccess disableWhileProcessing>
                            {({ processing, recentlySuccessful, errors }) => (
                                <>
                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <Alert className="border-green-200 bg-green-50 text-green-800 dark:border-green-700 dark:bg-green-900/20 dark:text-green-300">
                                            <AlertDescription>
                                                Upload successful! An email will be sent to the recipient shortly in 10 minutes.
                                            </AlertDescription>
                                        </Alert>
                                    </Transition>

                                    <div className="space-y-2">
                                        <Label htmlFor="credential" className="text-sm font-medium">
                                            Upload a Credential
                                        </Label>
                                        <Input id="credential" type="file" required name="credential" accept=".json,.oa" />
                                        <InputError message={errors.credential} />
                                    </div>

                                    <Button type="submit" disabled={processing} className="w-full">
                                        {processing ? 'Uploading...' : 'Upload'}
                                    </Button>
                                </>
                            )}
                        </Form>
                    </div>
                </div>
            </div>
        </>
    );
}
