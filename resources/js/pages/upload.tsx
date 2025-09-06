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

            <div className="p-10">
                <Heading title="POC - MOHESR" />
                <Form className="space-y-4" action={store()} resetOnSuccess>
                    {({ processing, recentlySuccessful, errors }) => (
                        <>
                            <Transition
                                show={recentlySuccessful}
                                enter="transition ease-in-out"
                                enterFrom="opacity-0"
                                leave="transition ease-in-out"
                                leaveTo="opacity-0"
                            >
                                <Alert className="border-green-200 bg-green-50 text-green-800">
                                    <AlertDescription>Upload successful!</AlertDescription>
                                </Alert>
                            </Transition>

                            <div className="grid w-full max-w-sm items-center gap-3">
                                <Label htmlFor="credential">Upload a Credential</Label>
                                <Input id="credential" type="file" required name="credential" />
                                <InputError message={errors.credential} />
                            </div>

                            <Button type="submit" disabled={processing}>
                                {processing ? 'Uploading...' : 'Upload'}
                            </Button>
                        </>
                    )}
                </Form>
            </div>
        </>
    );
}
